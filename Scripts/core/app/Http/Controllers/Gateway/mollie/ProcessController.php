<?php

namespace App\Http\Controllers\Gateway\mollie;

use App\Http\Controllers\PaymentController;
use Mollie\Laravel\Facades\Mollie;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Payment;
use Illuminate\Http\Request;
use Mollie\Api\MollieApiClient;

class ProcessController extends Controller
{

    public static function process($request, $gateway, $totalAmount, $deposit)
    {

        Mollie::api()->setApiKey($gateway->gateway_parameters->mollie_key);

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => $gateway->gateway_parameters->gateway_currency,
                "value" => ''.sprintf('%0.2f', round($totalAmount,2)).'', // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => "Payment For Purhcasing Plan",
            "redirectUrl" => route('user.payment.success'),
            'metadata' => [
                "order_id" => $deposit->transaction_id,
            ],

        ]);

        $payment = Mollie::api()->payments()->get($payment->id);

        session()->put('payment_id',$payment->id);
        session()->put('transaction_id',$deposit->transaction_id);


        return ['redirect_url' => $payment->getCheckoutUrl()];
    }

   
    public function paymentSuccess()
    {
    
    
        if(session('type') == 'deposit'){
            $deposit = Deposit::where('transaction_id', session('transaction_id'))->first();
        }else{
            $deposit = Payment::where('transaction_id', session('transaction_id'))->first();
        }

       Mollie::api()->setApiKey($deposit->gateway->gateway_parameters->mollie_key);

        $payment = Mollie::api()->payments()->get(session('payment_id'));

        if ($payment->isPaid()) {

            PaymentController::updateUserData($deposit,$deposit->charge, $deposit->transaction_id);

            $notify[] = ['success','Successfully Invested'];

            return redirect()->route('user.dashboard')->withNotify($notify);
        }
    }
}
