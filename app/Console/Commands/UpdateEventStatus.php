<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Carbon\Carbon;

#[Signature('app:update-event-status')]
#[Description('Automatically update event statuses')]
class UpdateEventStatus extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Ongoing -> Completed
        Event::whereDate('event_date', '<', $today)
            ->whereIn('status', ['Ongoing', 'Completed'])
            ->update([
                'status' => 'Completed'
            ]);

        // Draft & Upcoming -> Cancelled
        Event::whereDate('event_date', '<', $today)
            ->whereIn('status', ['Draft', 'Upcoming'])
            ->update([
                'status' => 'Cancelled'
            ]);

        $this->info('Event statuses updated successfully.');
    }

}
