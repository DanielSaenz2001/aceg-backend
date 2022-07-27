<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
   
    public function __construct($token,$email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {

        $user = User::whereEmail($this->email)->first();
        return $this->markdown('Email.passwordReset')->with([
            'user' => $user,
            'token' => $this->token
            
        ])->subject('Recuperar Contraseña')
        ->from('aceg@aceg.edu.pe')
        ;
    }
}