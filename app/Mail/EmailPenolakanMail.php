<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailPenolakanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alasan;

    public function __construct($alasan)
    {
        $this->alasan = $alasan;
    }

    public function build()
    {
        return $this->subject('Permohonan Email Lembaga Anda Ditolak')
                    ->view('emails.emailPenolakan');
    }
}
