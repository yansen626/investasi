<?php
/**
 * Created by PhpStorm.
 * User: yanse
 * Date: 30-Oct-17
 * Time: 10:24 AM
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PerjanjianPinjaman extends Mailable
{
    use Queueable, SerializesModels;

    protected $transaction;
    protected $user;
    protected $paymentMethod;
    protected $product;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payment, $transactionDB, $product, $user)
    {
        //
        $this->paymentMethod = $payment;
        $this->transaction = $transactionDB;
        $this->user = $user;
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Perjanjian Pinjaman di Indofund")
            ->view('email.perjanjian-pinjaman')->with([
            'transaction' => $this->transaction,
            'paymentMethod' => $this->paymentMethod,
            'product' => $this->product,
            'user' => $this->user,
        ]);
    }

}