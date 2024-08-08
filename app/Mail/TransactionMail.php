<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction;

class TransactionMail extends Mailable
{
    use Queueable, SerializesModels;


    public $transaction;
    /**
     * Create a new message instance.
     */

    public function __construct(\App\Models\Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function build()
    {
        return $this->markdown('emails.transaction')
        ->subject('Transaction '.$this->transaction->status)
        ->with(['transaction' => $this->transaction]);
    }
}
