<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subject;
    public $message;
    public $isConfirmation;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $isConfirmation = false)
    {
        $this->user = $data['user'];
        $this->subject = $data['subject'];
        $this->message = $data['message'];
        $this->isConfirmation = $isConfirmation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        if ($this->isConfirmation) {
            return $this->subject('Support Request Received - ' . $this->subject)
                ->from(config('mail.from.address'), config('mail.from.name'));
        }

        return $this->subject('New Support Request - ' . $this->subject)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->replyTo($this->user->email, $this->user->name);
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return $this->view($this->isConfirmation ? 'emails.support-confirmation' : 'emails.support');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
} 