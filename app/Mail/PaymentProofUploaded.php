<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentProofUploaded extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Bukti Transfer Baru - Booking #' . $this->booking->id . ' | TripWay',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.payment-proof-uploaded');
    }
}
