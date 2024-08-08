<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;
use Stripe\Checkout\Session;
use Stripe\Stripe;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Product;


class PaymentService
{
    public function getSessionUrl($customerData, $product)
    {
        //store email if customer does not exist
        $customer = Customer::firstOrCreate(['email' => $customerData['email']]);
        $customer->save();

        //strore transaction details
        $transaction = Transaction::create([
            'customer_id'=> $customer->id,
            'product_id' => $product->id,
            'amount' => $product->price,
            'status' => "pending"
        ]);
        $transaction->save();

        $session_url = $this->createStripeSession($transaction);

        return $session_url;
    }

    public function createStripeSession(Transaction $transaction)
    {

       Stripe::setApiKey(config('services.stripe.secret'));

       $session = Session::create([
            'payment_method_types' => ['card'],
            'payment_intent_data' =>[
                'setup_future_usage' => 'off_session',
            ],
                'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $transaction->product->name,
                    ],
                    'unit_amount' => round($transaction->amount / 2 * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'customer_email' => $transaction->customer->email,
            'success_url' => route('payment.success', ['transaction'=>$transaction->id]),
            'cancel_url' => route('payment.cancel', ['transaction'=>$transaction->id]),
            'metadata' => ['client_reference_id' => $transaction->id],
            'client_reference_id' => $transaction->id,
        ]);
        return $session->url;
    }
}