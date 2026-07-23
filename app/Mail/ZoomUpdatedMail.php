<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZoomUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $zoom;

    public function __construct($zoom) {
        $this->zoom = $zoom;
    }

    public function build() {
        return $this->subject('Pembaruan Status Request Zoom Pertemuan')
                    ->view('emails.zoom_updated');
    }
}