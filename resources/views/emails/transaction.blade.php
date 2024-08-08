@component('mail::message')

@if($transaction->status == 'paid')
# Payment Successful

Thank you for your purchase. Your deposit has been paid!

@elseif($transaction->status == "succeeded")

Your payment has been received in full.

@else

# Payment Failed

Unfortunately we could not process your transaction!

Contact us and quote Transaction ID#: {{$transaction->id}}

@endif

**Product:** {{ $transaction->product->name }}
@if($transaction->status == 'paid') 
**Deposit:** ${{number_format(round($transaction->amount / 2, 2),2) }}
@else 
**Price:** ${{$transaction->amount}}
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent