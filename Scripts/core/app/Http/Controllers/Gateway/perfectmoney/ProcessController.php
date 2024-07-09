<?php

namespace App\Http\Controllers\Gateway\perfectmoney;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Deposit;
use App\Models\Payment;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    public function returnSuccess(Request $request)
    {
        $request = json_decode(json_encode($request->all()));


        if (session('type') === 'deposit') {
            $depost = Deposit::where('transaction_id', $request->PAYMENT_ID)->first();
        } else {
            $depost = Payment::where('transaction_id', $request->PAYMENT_ID)->first();
        }

        $gateway = $depost->gateway->gateway_parameters;

        $passphrase = strtoupper(md5($gateway->passphrase));

        define('ALTERNATE_PHRASE_HASH', $passphrase);
        define('PATH_TO_LOG', '/asset/');
        $string =
            $request->PAYMENT_ID . ':' . $request->PAYEE_ACCOUNT . ':' .
            $request->PAYMENT_AMOUNT . ':' . $request->PAYMENT_UNITS . ':' .
            $request->PAYMENT_BATCH_NUM . ':' .
            $request->PAYER_ACCOUNT . ':' . ALTERNATE_PHRASE_HASH . ':' .
            $request->TIMESTAMPGMT;

        $hash = strtoupper(md5($string));
        $hash2 = $request->V2_HASH;


        $amount = $request->PAYMENT_AMOUNT;
        $unit = $request->PAYMENT_UNITS;
        $transaction = $request->PAYMENT_ID;
        if ($request->PAYEE_ACCOUNT == $gateway->accountid && $unit == $gateway->gateway_currency && $amount == $depost->final_amount) {
            PaymentController::updateUserData($depost, 0, $transaction);

            return redirect()->route('user.dashboard')->with('success','Payment Success');
        }
    }
}
