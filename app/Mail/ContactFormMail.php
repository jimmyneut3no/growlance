<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $message;
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
        $this->message = $data['message'];
        $this->isConfirmation = $isConfirmation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        if ($this->isConfirmation) {
            return $this->subject('Thank you for contacting Growlance')
                ->from(config('mail.from.address'), config('mail.from.name'));
        }

        return $this->subject('New Contact Form Submission')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->replyTo($this->email, $this->firstName . ' ' . $this->lastName);
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return $this->view($this->isConfirmation ? 'emails.contact-confirmation' : 'emails.contact');
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