<?php



namespace App\Mail;



use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

use App\Models\AkunEmailPribadi;



class EmailPribadiSetuju extends Mailable

{

    use Queueable, SerializesModels;



    public $akun;

    public $passwordPlain;



    public function __construct(AkunEmailPribadi $akun, $passwordPlain)

    {

        $this->akun = $akun;

        $this->passwordPlain = $passwordPlain;

    }



    public function build()

    {

        return $this->subject('Akun Email Pribadi Anda Telah Dibuat')

                    ->view('emails.emailSetuju');

    }

}

