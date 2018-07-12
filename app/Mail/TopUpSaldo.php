<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TopUpSaldo extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $description;
    protected $userGetFinal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $description, $userGetFinal)
    {
        //
        $this->user = $user;
        $this->description = $description;
        $this->userGetFinal = number_format($userGetFinal, 0, ",", ".");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Selamat! Dana Anda sudah bertambah")
            ->view('email.topup-saldo')->with([
            'user' => $this->user,
            'description' => $this->description,
            'userGetFinal' => $this->userGetFinal,
        ]);
    }
}
