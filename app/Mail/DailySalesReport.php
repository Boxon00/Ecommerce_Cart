<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class DailySalesReport extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Collection $orders,
        public Carbon $date
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Daily Sales Report - ' . $this->date->format('F d, Y'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.daily-sales',
        );
    }
}
