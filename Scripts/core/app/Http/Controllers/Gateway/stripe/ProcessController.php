<?php

namespace App\Http\Controllers\Gateway\stripe;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use Stripe;

class ProcessController extends Controller
{
    public static function process($request,$stripe , $payingAmount, $deposit)
    {
        Stripe\Stripe::setApiKey($stripe->gateway_parameters->stripe_client_secret);

        $payment = Stripe\Charge::create([
            "amount" => $payingAmount * 100,
            "currency" => $stripe->gateway_parameters->gateway_currency,
            "source" => $request->stripeToken,
            "description" => "{$deposit->transaction_id}"
        ]);

        $responseData = $payment->jsonSerialize();

        $transaction = $responseData['id'];

        $bal = \Stripe\BalanceTransaction::retrieve($responseData['balance_transaction']);

        $balJson = $bal->jsonSerialize();

        $fee_amount = number_format(($balJson['fee'] / 100), 4) /  $stripe->rate;

        if ($payment->status == 'succeeded') {
            
            PaymentController::updateUserData($deposit, $fee_amount, $transaction);

            $notify[] = ['success', 'Payment Successfully Done'];

            return redirect()->route('home')->withNotify($notify);
        }

        $notify[] = ['error', 'Something Goes Wrong'];
        return redirect()->route('home')->withNotify($notify);
    }
}
