<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InstallmentDone extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $description;
    protected $statements;
    protected $userGetFinal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $description, $statements, $userGetFinal)
    {
        //
        $this->user = $user;
        $this->description = $description;
        $this->statements = $statements;
        $this->userGetFinal = number_format($userGetFinal, 0, ",", ".");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Selamat! Dana Anda sudah bertambah dan pembayaran project telah selesai")
            ->view('email.installment-done')->with([
            'user' => $this->user,
            'description' => $this->description,
            'statements' => $this->statements,
            'userGetFinal' => $this->userGetFinal,
        ]);
    }
}
