<?php

namespace App\Console\Commands;

use App\Mail\ReminderMail;
use App\Models\Event;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('app:send-event-reminders')]
#[Description('Live event time reminders processed successfully!')]
class SendEventReminders extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $targetTime = Carbon::now()->addMinutes(30);

        // Find upcoming events starting soon
        $upcomingEvents = Event::with('tasks')->where('event_date', $now->toDateString())
            ->where('event_time', '>=', $now->toTimeString())
            ->where('event_time', '<=', $targetTime->toTimeString())
            ->get();


        foreach ($upcomingEvents as $event) {

            $notifiedUserIds = [];

            $formattedTime = Carbon::parse($event->event_time)->format('h:i A');

            foreach ($event->tasks as $task) {

                if ($task->assignee && !in_array($task->assigned_to, $notifiedUserIds)) {

                    $task->assignee->notify(
                        new GeneralNotification(
                            'Upcoming Event Reminder ⏰',
                            "Reminder: Your event '{$event->event_name}' starts at {$formattedTime}",
                            'reminder'
                        )
                    );

                    if ($task->assignee->email) {
                        Mail::to($task->assignee->email)
                            ->send(new ReminderMail($task->assignee, $event));
                    }

                    $notifiedUserIds[] = $task->assigned_to;
                }
            }

            $users = User::role(['SuperAdmin', 'EventManager'])
                ->whereNotIn('id', $notifiedUserIds)
                ->get();

            foreach ($users as $user) {

                $user->notify(
                    new GeneralNotification(
                        'Upcoming Event Reminder ⏰',
                        "Reminder: Event '{$event->event_name}' starts at {$formattedTime}",
                        'reminder'
                    )
                );

                if ($user->email) {
                    Mail::to($user->email)
                        ->send(new ReminderMail($user, $event));
                }
            }


        }

        $this->info('Single-user event time reminders processed successfully!');
    }
}

