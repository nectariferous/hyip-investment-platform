<?php

namespace App\Http\Controllers\Gateway\nowpayments;

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Controller;


class ProcessController extends Controller
{

    public static function process($request, $nowpay, $amount, $deposit)
    {

        $pay = new NowPaymentsAPI($nowpay->gateway_parameters->nowpay_key);

          $data = array(
            "price_amount" => $amount,
            "price_currency" => $nowpay->gateway_parameters->gateway_currency,
            "pay_currency" => "btc",
            "ipn_callback_url" => "https://nowpayments.io",
            "order_id" => $deposit->transaction_id,
            "order_description" => "Plan Purchage",
            'success_url'=> "{{route('user.nowpay.success')}}", 
	        'cancel_url'=>"{{route('user.nowpay.success')}}"
          );

          $a = json_decode($pay->createInvoice($data));

         
          return $a;
          
    }

    public function ipn()
    {
        # code...
    }
}
