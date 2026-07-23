<?php
namespace App\Mail;

use App\Models\SubDomain;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HostingApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subdomain;

    public function __construct(SubDomain $subdomain)
    {
        $this->subdomain = $subdomain;
    }

    public function build()
    {
        return $this->subject('Informasi Hosting & Sub Domain Disetujui')
                    ->view('emails.hosting_approved');
    }
}