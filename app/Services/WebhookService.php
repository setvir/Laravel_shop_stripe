<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Dispatch;

use Stripe\Webhook;
use Stripe\Stripe;
use Stripe\PaymentIntent;

use App\Mail\TransactionMail;
use App\Models\Transaction; 

use App\Jobs\SecondPayment;

use Throwable;

class WebhookService
{
    public function handleWebhook(Request $request){

        //check headers, endpoint key and request payload
        $event = $this->validateWebhook($request);

        //process event
        $this->handleWebhookEvents($event);
    }

	public function validateWebhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $endpointSecret = config('services.stripe.webhook_secret');

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);

        return $event;
    }

    public function handleWebhookEvents($event)
    {

        $data = $event->data->object;


        switch ($event->type) 
        {
            case 'checkout.session.completed':
               $this->processCompletedCheckoutSesson($data);
                break;
            case 'charge.succeeded':
                $this->processChargeSucceeded($data);
                break;
           // Add other event types as needed*/
           // default:
        }
    }

    public function processCompletedCheckoutSesson($data)
    {
       if($data->client_reference_id)
       {
            $transaction = Transaction::find($data->client_reference_id);
            $transaction->payment_intent_id = $data->payment_intent;
            $transaction->status = $data->payment_status;
            $transaction->save();
            
            $this->sendMail($transaction);


            if($data->payment_status == 'paid')
            {
                SecondPayment::dispatch($transaction)
                        ->delay(now()->addMinutes(5));

                Log::info("\nCaptured First Payment - Success :\n".$transaction);
            }
            else
            {
                Log::info("\nCaptured First Payment - Failed :\n".$transaction); 
            }
        }
    }

    public function processChargeSucceeded($data)
    {
        if($data->metadata->client_reference_id && $data->metadata->second_payment)
        {

            $transaction = Transaction::find($data->metadata->client_reference_id);
            $transaction->status = $data->status;
            $transaction->save();

            $this->sendMail($transaction);

            Log::info("\nCaptured Second Payment:\n".$transaction);
        }
    }

    public function sendMail(Transaction $transaction)
    {
        dispatch(function () use ($transaction) {
            Mail::to($transaction->customer->email)->send(new TransactionMail($transaction));
        })->catch(function (Throwable $e) {
            Log::error('Email send error: ', ['error' => $e->getMessage()]);
        });
    }

}