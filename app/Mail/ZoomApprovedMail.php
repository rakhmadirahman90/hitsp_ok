<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ZoomRequest;

class ZoomApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $zoom;

    public function __construct(ZoomRequest $zoom)
    {
        $this->zoom = $zoom;
    }

 public function build()
{
    return $this->subject('Link Zoom Anda Telah Disetujui')
                ->view('emails.zoom_approved');
}
}
