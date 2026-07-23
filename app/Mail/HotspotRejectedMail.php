<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HotspotRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $hotspot;

    /**
     * Create a new message instance.
     */
    public function __construct($hotspot)
    {
        $this->hotspot = $hotspot;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Permohonan Hotspot Ditolak')
                    ->view('emails.hotspot_rejected');
    }
}