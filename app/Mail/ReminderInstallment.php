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

class ReminderInstallment extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $productInstallment;
    protected $product;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $product, $productInstallment)
    {
        //
        $this->productInstallment = $productInstallment;
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
        return $this->subject("Reminder Pembayaran Cicilan Indofund")
            ->view('email.reminder-installment')->with([
            'productInstallment' => $this->productInstallment,
            'product' => $this->product,
            'user' => $this->user,
        ]);
    }

}