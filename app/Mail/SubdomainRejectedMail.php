<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubdomainRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subdomain;
    public $alasan;

    public function __construct($subdomain, $alasan)
    {
        $this->subdomain = $subdomain;
        $this->alasan = $alasan;
    }

    public function build()
    {
        return $this->subject('Permohonan Sub Domain Ditolak')
                    ->view('emails.subdomain_rejected');
    }
}