<?php

namespace App\Http\Controllers\Gateway\vouguepay;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Payment;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    public function returnSuccess(Request $request)
    {
        
        $request->validate([
            'transaction_id' => 'required'
        ]);

        $vougue_url = "https://voguepay.com/?v_transaction_id=$request->transaction_id&type=json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_URL, $vougue_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $vougueData = curl_exec($ch);
        curl_close($ch);

        $vougueData = json_decode($vougueData);
        $transaction_id = $vougueData->merchant_ref;

        $deposit = Payment::where('transaction_id', $transaction_id)->first();
        if ($vougueData->status == "Approved") {
            PaymentController::updateUserData($deposit, $deposit->charge, $request->transaction_id);
        }
    
    }
}