<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $contactMessage;
    public $isConfirmation;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $isConfirmation = false)
    {
        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
        $this->email = $data['email'];
        $this->phone = $data['phone'] ?? null;
        $this->contactMessage = $data['message'];
        $this->isConfirmation = $isConfirmation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if ($this->isConfirmation) {
        return new Envelope(
            subject: 'Thank you for contacting Growlance',
            replyTo: [config('mail.from.reply_to')],
        );
        }
        return new Envelope(
            subject: 'New Contact Form Submission',
            replyTo: [$this->email],
        );
    }
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->isConfirmation ? 'emails.contact-confirmation' : 'emails.contact',
        );
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