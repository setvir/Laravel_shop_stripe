<?php

namespace App\Jobs;
use Illuminate\Support\Facades\Log;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Customer as StripeCustomer;

use App\Models\Transaction;

class SecondPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Transaction $transaction)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $previousPaymentIntent = PaymentIntent::retrieve($this->transaction->payment_intent_id);
        
        $paymentMethodID = $previousPaymentIntent->payment_method;

        $paymentMethod = PaymentMethod::retrieve($paymentMethodID);

        // Check if the customer already has a stripe_customer_id
        if (empty($this->transaction->customer->stripe_customer_id)) {
            $customer = StripeCustomer::create([
                'email' => $this->transaction->customer->email,
                'payment_method' => $paymentMethod->id,
                'invoice_settings' => ['default_payment_method' => $paymentMethod->id],
            ]);
            // Save the Stripe customer ID in your local database
            $this->transaction->customer->stripe_customer_id = $customer->id;
            $this->transaction->customer->save();
        } else {
            $customer = StripeCustomer::retrieve($this->transaction->customer->stripe_customer_id);
        }

        // Attach the payment method to the customer
        $paymentMethod->attach(['customer' => $customer->id]);

        $amount = ($this->transaction->amount * 100) - round($this->transaction->amount / 2, 2) * 100;

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'customer' => $customer->id,
            'payment_method' => $paymentMethod->id,
            'off_session' => true,
            'confirm' => true,
            'automatic_payment_methods' => [
                'enabled' => true,
                'allow_redirects' => 'never',
            ],
            'metadata' => [
                'client_reference_id' => $this->transaction->id,
                'second_payment' => true
            ],
        ]);
    }
}