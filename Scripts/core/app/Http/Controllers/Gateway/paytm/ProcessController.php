<?php

namespace App\Http\Controllers\Gateway\paytm;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Models\Payment;
use Illuminate\Http\Request;
use PaytmWallet;

class ProcessController extends Controller
{
    private static $sandbox_endpoint_payment = 'https://securegw-stage.paytm.in/theia/processTransaction';
    private static $production_endpoint_payment = 'https://securegw.paytm.in/theia/processTransaction';

    public static function process($request, $paytm, $totalAmount, $deposit)
    {


        $paytm_params['MID'] = trim($paytm->gateway_parameters->merchant_id);
        $paytm_params['WEBSITE'] = trim($paytm->gateway_parameters->merchant_website);
        $paytm_params['CHANNEL_ID'] = trim($paytm->gateway_parameters->merchant_channel);
        $paytm_params['INDUSTRY_TYPE_ID'] = trim($paytm->gateway_parameters->merchant_industry);


        $paytm_params['ORDER_ID'] = $deposit->transaction_id;
        $paytm_params['TXN_AMOUNT'] = round($totalAmount, 2);
        $paytm_params['CUST_ID'] = $deposit->user_id;
        $paytm_params['CALLBACK_URL'] = route('user.paytm.success');
        $paytm_params['CHECKSUMHASH'] = (new paytmCheckSum())->getChecksumFromArray($paytm_params, $paytm->gateway_parameters->merchant_key);

        $response['paytm_params'] = $paytm_params;
        if ($paytm->gateway_parameters->mode) {
            $response['redirect_url'] = self::$production_endpoint_payment;
        } else {
            $response['redirect_url'] = self::$sandbox_endpoint_payment;
        }


        return json_decode(json_encode($response));
    }

    public function returnSuccess(Request $request)
    {

        if (session('type') == 'deposit') {
            $payment = Deposit::where('transaction_id', $request['ORDERID'])->first();
        } else {
            $payment = Payment::where('transaction_id', $request['ORDERID'])->first();
        }



        $ptm = new paytmCheckSum();

        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";
        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : "";
        $isValidChecksum = $ptm->verifychecksum_e($paramList, $payment->gateway->gateway_parameters->merchant_key, $paytmChecksum);

        $amount_paid = $request['TXNAMOUNT'];

        if ($isValidChecksum == "TRUE") {
            if ($_POST["STATUS"] == "TXN_SUCCESS") {
                $payment_mode = $request['PAYMENTMODE'];
                if (isset($_POST['BANKNAME']) && !empty($request['BANKNAME'])) {
                    $payment_id = $request['BANKNAME'] . '-' . $request['BANKTXNID'];
                } else {
                    $payment_id = $request['BANKTXNID'];
                }
                $order_id   = $request['ORDERID'];
                $amount_received = $request['TXNAMOUNT'];

                PaymentController::updateUserData($payment, 0, $request['BANKTXNID']);
            } else {
                return redirect()->route('user.dashboard')->with('error', 'Payment Unsuccessfull');
            }
        } else {
            return redirect()->route('user.dashboard')->with('error', 'Some Error Occured');
        }

        return redirect()->route('user.dashboard')->with('success', 'Payment Successfull');
    }
}
