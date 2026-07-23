<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\HotspotUser;

class HotspotApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $hotspot;
    public $username;
    public $password;

    public function __construct(HotspotUser $hotspot, $username, $password)
    {
        $this->hotspot = $hotspot;
        $this->username = $username;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Akun Hotspot Disetujui')
                    ->view('emails.hotspot_approved');
    }
}