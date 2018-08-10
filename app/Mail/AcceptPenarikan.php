<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptPenarikan extends Mailable
{
    use Queueable, SerializesModels;

    protected $statement;
    protected $user;
    protected $type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($statement, $user, $type)
    {
        //
        $this->statement = $statement;
        $this->user = $user;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //type, 1=accepted, 0=rejected
        if($this->type == 1){
            return $this->subject("SELAMAT, Penarikan Dana Anda BERHASIL")
                ->view('email.accept-penarikan')->with([
                    'statement' => $this->statement,
                    'user' => $this->user,
                ]);
        }
        else{
            return $this->subject("MAAF, pencairan dana anda GAGAL")
                ->view('email.reject-penarikan')->with([
                    'statement' => $this->statement,
                    'user' => $this->user,
                ]);
        }
    }
}
