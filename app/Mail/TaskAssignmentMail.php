<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAssignmentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // public $afterCommit = true; 

    public $task;
    public $event;
    public $assignee;
    public $assigner;

    /**
     * Create a new message instance.
     */
    public function __construct($task, $event, $assignee, $assigner)
    {
        $this->task = $task;
        $this->event = $event;
        $this->assignee = $assignee;
        $this->assigner = $assigner;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Task Assigned to You',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'backend.emails.task-assignment',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
