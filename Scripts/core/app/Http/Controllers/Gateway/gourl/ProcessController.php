<?php

namespace App\Http\Controllers\Gateway\gourl;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Deposit;
use App\Models\Payment;
use Illuminate\Http\Request;
use Victorybiz\LaravelCryptoPaymentGateway\LaravelCryptoPaymentGateway;

class ProcessController extends Controller
{
    public static function process($request, $gateway, $amount, $deposit)
    {
        $payment_url = LaravelCryptoPaymentGateway::startPaymentSession([
            'amountUSD' => $amount, // OR 'amount' when sending BTC value
            'orderID' => $deposit->transaction_id,
            'userID' => auth()->id(),
            'redirect' => url()->full(),
        ]);


        return $payment_url;
    }

    public function callback(Request $request)
    {
        return LaravelCryptoPaymentGateway::callback();
    }

    public static function ipn($cryptoPaymentModel, $payment_details, $box_status)
    {
        if ($cryptoPaymentModel) {
            
            $userOrder = Payment::where('transation_id', $cryptoPaymentModel->paymentID)->first();
            

            // Received second IPN notification (optional) - Bitcoin payment confirmed (6+ transaction confirmations)
            if ($userOrder && $box_status == "cryptobox_updated")
            {
                $userOrder->txconfirmed = $payment_details["confirmed"];
                $userOrder->save();
            }
            

            // Onetime action when payment confirmed (6+ transaction confirmations)
            if (!$cryptoPaymentModel->processed && $payment_details["confirmed"]) {
                // Add your custom logic here to give value to the user.

                PaymentController::updateUserData($userOrder, floatval($payment_details["amount"]), $cryptoPaymentModel->paymentID);

                // ------------------
                // set the status of the payment to processed
                // $cryptoPaymentModel->setStatusAsProcessed();

                // ------------------
                // Add logic to send notification of confirmed/processed payment to the user if any
            }
        }
        return true;
    }
}
