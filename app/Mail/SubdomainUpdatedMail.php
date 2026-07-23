<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\SubDomain;

class SubdomainUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subdomain;

    /**
     * Create a new message instance.
     *
     * @param SubDomain $subdomain
     */
    public function __construct(SubDomain $subdomain)
    {
        $this->subdomain = $subdomain;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pembaruan Data Permohonan Sub Domain & Hosting')
                    ->view('emails.subdomain_updated');
    }
}