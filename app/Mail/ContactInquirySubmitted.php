<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactInquirySubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array $inquiry,
        public ?string $ipAddress = null,
    ) {
    }

    public function envelope(): Envelope
    {
        $type = str_replace('_', ' ', $this->inquiry['inquiry_type'] ?? 'general');

        return new Envelope(
            replyTo: [
                new Address($this->inquiry['email'], $this->inquiry['name']),
            ],
            subject: 'New DormEase Contact Inquiry: ' . ucfirst($type),
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.contact-inquiry',
        );
    }
}
