<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use Stripe\Exception\ApiErrorException;

use App\Http\Requests\CustomerRequest;
use App\Services\PaymentService;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Product;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }


    //page on success
    public function success($transactionId)
    {
        $transaction=Transaction::find($transactionId);
        return view('checkout.thankyou', compact('transaction'));
    }


    //page on cancel
    public function cancel($transactionId)
    {
        $transaction=Transaction::find($transactionId);
        return view('checkout.cancel', compact('transaction'));
    }

    public function createPayment(CustomerRequest $request, Product $product)
    {
        try
        {
            // Setup session and retrieve session URL
            $session_url = $this->paymentService->getSessionUrl($request->validated(), $product);
        }
        catch (ApiErrorException $e)
        {
            Log::error('Stripe API Error:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', "There was an issue connecting to the payment gateway. Please try again.");
        }/*
        catch (\Exception $e) 
        {
            Log::error('Payment Error:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong processing your transaction, please try again. If this problem persists, please contact us.");
        }*/

        // Redirect to the Stripe hosted checkout page
        return redirect()->away($session_url);
    }
}