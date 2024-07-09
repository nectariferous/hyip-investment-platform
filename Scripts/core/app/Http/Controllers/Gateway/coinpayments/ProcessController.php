<?php

namespace App\Http\Controllers\Gateway\coinpayments;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\coinpayments\CoinPaymentsAPI;
use App\Http\Controllers\PaymentController;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Payment;
use Illuminate\Http\Request;

class ProcessController extends Controller
{

    public static function process($request, $coinpayments, $payingAmount, $deposit)
    {

        $request->validate([
            'email' => 'required|email'
        ]);

        $totalAmount = $payingAmount;
        $cps = new CoinPaymentsAPI();

        $cps->Setup($coinpayments->gateway_parameters->private_key, $coinpayments->gateway_parameters->public_key);

        $req = array(
            'amount' => $totalAmount,
            'currency1' => $coinpayments->gateway_parameters->gateway_currency,
            'currency2' => 'BTC',
            'buyer_email' => $request->email,
            'custom' => $deposit->transaction_id,
            'item_name' => 'Payment',
            'address' => '', // leave blank send to follow your settings on the Coin Settings page
            'ipn_url' => route('user.coin.pay'),
        );

        $result = $cps->CreateTransaction($req);


        if ($result['error'] == 'ok') {
            $deposit->btc_wallet = $result['result']['address'];
            $deposit->btc_amount = $result['result']['amount'];
            $deposit->btc_trx = $result['result']['txn_id'];
            $deposit->save();

            return $result;
        } else {
            print 'Error: ' . $result['error'] . "\n";
        }
    }

    public function ipn(Request $request)
    {
        $trx = session('trx');

        $coin = Gateway::where('gateway_name', 'coinpayments')->first();

        if (session('type') == 'deposit') {
            $booking = Deposit::where('transaction_id', $trx)->first();
        } else {
            $booking = Payment::where('transaction_id', $trx)->first();
        }

        if ($booking) {
            PaymentController::updateUserData($booking, 0, $trx);
            $notify[] = ['success', 'Payment Successfully Done'];
            return redirect()->route('user.dashboard')->withNotify($notify);
        }
    }
}
