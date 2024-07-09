<?php

namespace App\Http\Controllers\Gateway\razorpay;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Deposit;
use App\Models\Payment;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class ProcessController extends Controller
{
    public function returnSuccess(Request $request)
    {
        $request = $request->all();

        if(session('type') == 'deposit'){
            $deposit = Deposit::where('transaction_id', session('trx'))->first();
        }else{
            $deposit = Payment::where('transaction_id', session('trx'))->first();
        }

        if(isset($request['razorpay_payment_id'])) {
            
            PaymentController::updateUserData($deposit, 0, $request['razorpay_payment_id']);

            $notify [] = ['success','Plan Subscribed Successfully'];
    
            return redirect()->route('user.dashboard')->withNotify($notify);
        }


    }
}
