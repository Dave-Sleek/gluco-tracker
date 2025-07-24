<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FeedbackResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $feedbackId;
    public $fullName;
    public $reply;

    public function __construct($feedbackId, $fullName, $reply)
    {
        $this->feedbackId = $feedbackId;
        $this->fullName = $fullName;
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->subject("Response to your feedback (#{$this->feedbackId})")
                    ->view('admin.emails.feedback_reply');
    }

    /**
     * Create a new message instance.
     */
    // public function __construct()
    // {
    //     //
    // }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Feedback Response',
        );
    }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
