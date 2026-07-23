<?php



namespace App\Mail;



use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;



class EmailPribadiTolak extends Mailable

{

    use Queueable, SerializesModels;



    public $permohonan;

    public $alasan;



    public function __construct($permohonan, $alasan)

    {

        $this->permohonan = $permohonan;

        $this->alasan = $alasan;

    }



    public function build()

    {

        return $this->subject('Permohonan Email Pribadi Ditolak')

                    ->view('emails.emailTolak');

    }

}

