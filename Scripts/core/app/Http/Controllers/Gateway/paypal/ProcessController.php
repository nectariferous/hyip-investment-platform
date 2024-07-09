<?php

namespace App\Http\Controllers\Gateway\paypal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Payment as ModelsPayment;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;

class ProcessController extends Controller
{
    public function process($request, $paypal, $totalAmount, $deposit)
    {
        
        $apiContext = new ApiContext(
            new OAuthTokenCredential(

                $paypal->gateway_parameters->paypal_client_id,
                $paypal->gateway_parameters->paypal_client_secret,

            )
        );



        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // Set redirect URLs
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('user.paypal'))
            ->setCancelUrl(route('home'));


        // Set payment amount
        $amount = new Amount();
        $amount->setCurrency($paypal->gateway_parameters->gateway_currency)
            ->setTotal($totalAmount);

        // Set transaction object
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription("Transaction Number {$deposit->transaction_id}");

        // Create the full payment object
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));


        // Create payment with valid API context
        try {
            $payment->create($apiContext);

            // Get PayPal redirect URL and redirect the customer
            $approvalUrl = $payment->getApprovalLink();

            // Redirect the customer to $approvalUrl
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (\Exception $ex) {
            die($ex);
        }

        return $payment;
           
    }


    public function ipn()
    {
        $paypal = Gateway::where('gateway_name', 'paypal')->firstOrFail();

        if(session('type') == 'deposit'){
            $booking = Deposit::where('transaction_id', session('trx'))->first();
        }else{
            $booking = ModelsPayment::where('transaction_id', session('trx'))->first();
        }

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypal->gateway_parameters->paypal_client_id,
                $paypal->gateway_parameters->paypal_client_secret,
            )
        );

        // Get payment object by passing paymentId
        $paymentId = $_GET['paymentId'];
        $payment = Payment::get($paymentId, $apiContext);
        $payerId = $_GET['PayerID'];

        // Execute payment with payer ID
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            // Execute payment
            $result = $payment->execute($execution, $apiContext);

            $transaction = $result->id;

            $transactionFee = json_decode($result)->transactions[0]->related_resources[0]->sale->transaction_fee->value / $paypal->rate;

            if ($result->state == 'approved') {

                PaymentController::updateUserData($booking, $transactionFee, $transaction);

                $notify[] = ['success', 'Payment Successfully Done'];
                return redirect()->route('dashboard')->withNotify($notify);
            }
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (\Exception $ex) {
            die($ex);
        }
    }
}