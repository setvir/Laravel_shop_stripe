<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;

use App\Services\WebhookService;

class WebhookController extends Controller
{

    public function __construct(private WebhookService $webhookService)
    {
    }

    public function webhook(Request $request)
    {
        try 
        {   
            // Handle the webhook request
            $this->webhookService->handleWebhook($request);
        }
        catch (UnexpectedValueException $e) 
        {
            // Invalid payload
            Log::error('Stripe Webhook Error: Invalid payload', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid payload'], 400);
        }
        catch (SignatureVerificationException $e) 
        {
            // Invalid signature
            Log::error('Stripe Webhook Error: Invalid signature', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }
        catch (\Exception $e) 
        {
            // General exception catch for unexpected errors
            Log::error('Stripe Webhook Error: General exception', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }

        return response()->json(['status' => 'success'], 200);
    }
}