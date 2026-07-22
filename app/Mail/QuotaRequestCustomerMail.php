<?php

namespace App\Mail;

use App\Models\QuotaRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuotaRequestCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public QuotaRequest $quotaRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We received your quotation request ('.$this->quotaRequest->reference.')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.quota-request-customer',
        );
    }
}
