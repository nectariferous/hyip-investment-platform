<?php

namespace App\Http\Controllers\Gateway\mercadopago;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Models\Payment;
use Illuminate\Http\Request;


class ProcessController extends Controller
{

    public static function process($request, $gateway, $amount, $deposit)
    {
        $general = GeneralSetting::first();

        $sandbox = false;

        $url = "https://api.mercadopago.com/checkout/preferences?access_token=" . $gateway->gateway_parameters->access_token;
        $headers = [
            "Content-Type: application/json",
        ];
        $postParam = [
            'items' => [
                [
                    'id' => $deposit->transaction_id,
                    'title' => number_format($amount, 2) . ' ' . $gateway->gateway_parameters->gateway_currency,
                    'description' => "Plan Purchase",
                    'installment' => 1,
                    'quantity' => 1,
                    'currency_id' => $gateway->gateway_parameters->gateway_currency,
                    'unit_price' => round($amount, 2)
                ]
            ],
            'payer' => [
                'email' => $deposit->user->email ?? '',
            ],
            'back_urls' => [
                'success' => route('user.dashboard'),
                'pending' => '',
                'failure' => route('user.dashboard'),
            ],
            'notification_url' => route('user.mercadopago.success'),
            'auto_return' => 'approved',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postParam));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result);

        $send['preference'] = $preference->id ?? '';

        if (isset($response->auto_return) && $response->auto_return == 'approved') {
            if ($sandbox) {
                $send['redirect'] = true;
                $send['redirect_url'] = $response->sandbox_init_point;
            } else {
                $send['redirect'] = true;
                $send['redirect_url'] = $response->init_point;
            }
        } else {
            $send['error'] = true;
            $send['message'] = 'Invalid Request';
        }
        return $send;
    }

    public static function returnSuccess(Request $request)
    {


        if (session('type') == 'deposit') {
            $deposit = Deposit::where('transaction_id', session('transaction_id'))->first();
        } else {
            $deposit = Payment::where('transaction_id', session('transaction_id'))->first();
        }


        $url = "https://api.mercadopago.com/v1/payments/" . $request['data']['id'] . "?access_token=" . $deposit->gateway->gateway_parameters->access_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $paymentData = json_decode($result);

        if (isset($paymentData->status) && $paymentData->status == 'approved') {
            PaymentController::updateUserData($deposit, 0, $deposit->transacation_id);

            return redirect()->route('user.dashboard');
        }
    }
}
