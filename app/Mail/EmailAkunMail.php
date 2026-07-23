<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailAkunMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nama_akun;
    public $password;

    public function __construct($nama_akun, $password)
    {
        $this->nama_akun = $nama_akun;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Akun Email Lembaga Anda Telah Dibuat')
                    ->view('emails.emailAkun');
    }
}
