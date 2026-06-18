<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $type;
    protected $data;

    public function __construct($type, $data = [])
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->line('You have a new notification.')
            ->action('View', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return match ($this->type) {

            'event_create' => [
                'title' => 'New Event Assigned 🎉',
                'message' => 'You have been assigned to: ' . $this->data['event_name'],
                'type' => $this->type,
            ],

            'event_update' => [
                'title' => 'Event Updated 🔄',
                'message' => 'The event "' . $this->data['event_name'] .
                    '" has been updated to ' . $this->data['event_date'],
                'type' => $this->type,
            ],

            'event_created_by_you' => [
                'title' => 'Event Created Successfully ✔️',
                'message' => 'You successfully created: ' . $this->data['event_name'],
                'type' => $this->type,
            ],

            'task_create' => [
                'title' => 'New Task Assigned 📋', 
                'message' => 'You have been assigned the task: ' . $this->data['task_title'], 
                'type' => $this->type,],
            
            'task_created_by_you' => [
                'title' => 'Task Created Successfully ✔️', 
                'message' => 'You successfully created the task: ' . $this->data['task_title'], 
                'type' => $this->type,],

            default => [
                'title' => 'Notification',
                'message' => 'You have a new notification.',
                'type' => $this->type,
            ],
        };
    }

}
