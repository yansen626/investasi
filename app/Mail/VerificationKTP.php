<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerificationKTP extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $description;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $description)
    {
        //
        $this->user = $user;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Verifikasi Data KTP di Indofund")
            ->view('email.verification-ktp')->with([
                'user' => $this->user,
                'description' => $this->description
        ]);
    }
}
