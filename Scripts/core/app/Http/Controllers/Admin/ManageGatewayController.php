<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\GeneralSetting;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManageGatewayController extends Controller
{
    public function bank()
    {
        $data['pageTitle'] = 'Bank Payment';
        $data['navPaymentGatewayActiveClass'] = 'active';
        $data['subNavBankPaymentActiveClass'] = 'active';

        $data['gateway'] = Gateway::where('gateway_name', 'bank')->first();

        return view('backend.gateways.bank')->with($data);
    }

    public function bankUpdate(Request $request)
    {

        $gateway = Gateway::where('gateway_name', 'bank')->first();

        $request->validate([
            "name" => 'required',
            "account_number" => 'required',
            "routing_number" => 'required',
            "branch_name" => 'required',
            "user_proof_param" => 'sometimes|array',
            'bank_image' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required',
            'rate' => 'required',
            'charge' => 'required',
            'gateway_currency' => 'required'
        ]);


        $gatewayParameters = [
            'name' => $request->name,
            'account_number' => $request->account_number,
            'routing_number' => $request->routing_number,
            'branch_name' => $request->branch_name,
            'gateway_currency' => $request->gateway_currency
        ];


        if ($gateway) {
            if ($request->hasFile('bank_image')) {
                $filename = uploadImage($request->bank_image, gatewayImagePath(), '', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $gatewayParameters,
                'user_proof_param' => array_values($request->user_proof_param),
                'status' => $request->status,
                'rate' => $request->rate,
                'charge' => $request->charge
            ]);


            $notify[] = ['success', "Bank Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('bank_image')) {
            $filename = uploadImage($request->bank_image, gatewayImagePath());
        }


        Gateway::create([
            'gateway_name' => 'bank',
            'gateway_image' => $filename,
            'gateway_parameters' => $gatewayParameters,
            'user_proof_param' => array_values($request->user_proof_param),
            'gateway_type' => 0,
            'status' => $request->status,
            'rate' => $request->rate,
            'charge' => $request->charge
        ]);


        $notify[] = ['success', "Bank Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }

    public function paypal()
    {
        $data['pageTitle'] = 'Paypal Payment';
        $data['navPaymentGatewayActiveClass'] = 'active';
        $data['subNavPaypalPaymentActiveClass'] = 'active';

        $data['gateway'] = Gateway::where('gateway_name', 'paypal')->first();

        return view('backend.gateways.paypal')->with($data);
    }


    public function paypalUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'paypal')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'paypal_client_id' => 'required',
            'paypal_client_secret' => 'required',
            'paypal_image' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            })],
            'status' => 'required',
            'mode' => 'required',
            'rate' => 'required'
        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'paypal_client_id' => $request->paypal_client_id,
            'paypal_client_secret' => $request->paypal_client_secret,
            'mode' => $request->mode
        ];


        if ($gateway) {
            if ($request->hasFile('paypal_image')) {
                $filename = uploadImage($request->paypal_image, gatewayImagePath(), '', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'status' => $request->status,
                'rate' => $request->rate
            ]);


            $notify[] = ['success', "Paypal Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('paypal_image')) {
            $filename = uploadImage($request->paypal_image, gatewayImagePath());
        }


        Gateway::create([
            'gateway_name' => 'paypal',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'status' => $request->status,
            'rate' => $request->rate,

        ]);


        $notify[] = ['success', "Paypal Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }

    public function coin()
    {
        $data['pageTitle'] = 'Coin Payment';
        $data['navPaymentGatewayActiveClass'] = 'active';
        $data['subNavCoinpaymentsPaymentActiveClass'] = 'active';

        $data['gateway'] = Gateway::where('gateway_name', 'coinpayments')->first();

        return view('backend.gateways.coin')->with($data);
    }


    public function coinUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'coinpayments')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'public_key' => 'required',
            'private_key' => 'required',
            'merchant_id' => 'required',
            'coin_image' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required',
            'rate' => 'required',

        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'public_key' => $request->public_key,
            'private_key' => $request->private_key,
            'merchant_id' => $request->merchant_id
        ];


        if ($gateway) {
            if ($request->hasFile('coin_image')) {

                $filename = uploadImage($request->coin_image, gatewayImagePath(), '', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'status' => $request->status,
                'rate' => $request->rate,

            ]);


            $notify[] = ['success', "CoinPayment Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('coin_image')) {
            $filename = uploadImage($request->coin_image, gatewayImagePath());
        }


        Gateway::create([
            'gateway_name' => 'coinpayments',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'status' => $request->status,
            'rate' => $request->rate,

        ]);


        $notify[] = ['success', "CoinPayment Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }


    public function stripe()
    {
        $data['pageTitle'] = 'Stripe Payment';
        $data['navPaymentGatewayActiveClass'] = 'active';
        $data['subNavStripePaymentActiveClass'] = 'active';


        $data['gateway'] = Gateway::where('gateway_name', 'stripe')->first();

        return view('backend.gateways.stripe')->with($data);
    }


    public function stripeUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'stripe')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'stripe_client_id' => 'required',
            'stripe_client_secret' => 'required',
            'stripe_image' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required',
            'rate' => 'required',

        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'stripe_client_id' => $request->stripe_client_id,
            'stripe_client_secret' => $request->stripe_client_secret,
        ];


        if ($gateway) {
            if ($request->hasFile('stripe_image')) {
                $filename = uploadImage($request->stripe_image, gatewayImagePath(), '', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'status' => $request->status,
                'rate' => $request->rate,

            ]);


            $notify[] = ['success', "Stripe Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('stripe_image')) {
            $filename = uploadImage($request->stripe_image, gatewayImagePath());
        }


        Gateway::create([
            'gateway_name' => 'stripe',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'status' => $request->status,
            'rate' => $request->rate,

        ]);


        $notify[] = ['success', "Stripe Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }

    public function razorpay()
    {
        $data['pageTitle'] = 'Razorpay Payment';
        $data['navPaymentGatewayActiveClass'] = 'active';
        $data['subNavRazorpayPaymentActiveClass'] = 'active';


        $data['gateway'] = Gateway::where('gateway_name', 'razorpay')->first();

        return view('backend.gateways.razorpay')->with($data);
    }


    public function razorpayUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'razorpay')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'razor_key' => 'required',
            'razor_secret' => 'required',
            'razor_image' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required',
            'rate' => 'required',

        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'razor_key' => $request->razor_key,
            'razor_secret' => $request->razor_secret,
        ];


        if ($gateway) {
            if ($request->hasFile('razor_image')) {

                $filename = uploadImage($request->razor_image, gatewayImagePath(), '', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'status' => $request->status,
                'rate' => $request->rate,

            ]);


            $notify[] = ['success', "RazorPay Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('razor_image')) {
            $filename = uploadImage($request->razor_image, gatewayImagePath());
        }


        Gateway::create([
            'gateway_name' => 'razorpay',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'status' => $request->status,
            'rate' => $request->rate,

        ]);


        $notify[] = ['success', "RazorPay Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }


    public function vouguepay()
    {
        $data['pageTitle'] = 'Vouguepay Payment';
        $data['navPaymentGatewayActiveClass'] = 'active';
        $data['subNavVougePayPaymentActiveClass'] = 'active';

        $data['gateway'] = Gateway::where('gateway_name', 'vouguepay')->first();

        return view('backend.gateways.vouguepay')->with($data);
    }

    public function vouguepayUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'vouguepay')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'vouguepay_merchant_id' => 'required',
            'rate' => 'required|gt:0',
            'vouguepay_image' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required'
        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'vouguepay_merchant_id' => $request->vouguepay_merchant_id
        ];


        if ($gateway) {
            if ($request->hasFile('vouguepay_image')) {
                $filename = uploadImage($request->vouguepay_image, gatewayImagePath(), '200x200', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'rate' => $request->rate,
                'status' => $request->status
            ]);


            $notify[] = ['success', "VouguePay Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('vouguepay_image')) {
            $filename = uploadImage($request->vouguepay_image, gatewayImagePath(), '200x200');
        }


        Gateway::create([
            'gateway_name' => 'vouguepay',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'rate' => $request->rate,
            'status' => $request->status
        ]);


        $notify[] = ['success', "VouguePay Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }


    public function mollie()
    {
        $data['pageTitle'] = 'Mollie Payment';
        $data['navPaymentGatewayActiveClass'] = 'show';
        $data['subNavMolliePaymentActiveClass'] = 'active';

        $data['gateway'] = Gateway::where('gateway_name', 'mollie')->firstOrFail();

        return view('backend.gateways.mollie')->with($data);
    }

    public function mollieUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'mollie')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'mollie_key' => 'required',
            'rate' => 'required|gt:0',
            'mollie_image' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required'
        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'mollie_key' => $request->mollie_key
        ];


        if ($gateway) {
            if ($request->hasFile('mollie_image')) {
                $filename = uploadImage($request->mollie_image, gatewayImagePath(), '200x200', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'rate' => $request->rate,
                'status' => $request->status
            ]);


            $notify[] = ['success', "Mollie Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('mollie_image')) {
            $filename = uploadImage($request->mollie_image, gatewayImagePath(), '200x200');
        }


        Gateway::create([
            'gateway_name' => 'mollie',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'rate' => $request->rate,
            'status' => $request->status
        ]);


        $notify[] = ['success', "Mollie Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }

    public function nowPayments()
    {
        $data['pageTitle'] = 'NowPayments';
        $data['navPaymentGatewayActiveClass'] = 'show';
        $data['subNavNowPaymentActiveClass'] = 'active';

        $data['gateway'] = Gateway::where('gateway_name', 'nowpayments')->firstOrFail();


        return view('backend.gateways.nowpayments')->with($data);
    }

    public function nowPaymentsUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'nowpayments')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'nowpay_key' => 'required',
            'rate' => 'required|gt:0',
            'nowpay_image' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required'
        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'nowpay_key' => $request->nowpay_key
        ];


        if ($gateway) {
            if ($request->hasFile('nowpay_image')) {
                $filename = uploadImage($request->nowpay_image, gatewayImagePath(), '200x200', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'rate' => $request->rate,
                'status' => $request->status
            ]);


            $notify[] = ['success', "NowPay Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('nowpay_image')) {
            $filename = uploadImage($request->nowpay_image, gatewayImagePath(), '200x200');
        }


        Gateway::create([
            'gateway_name' => 'nowpayments',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'rate' => $request->rate,
            'status' => $request->status
        ]);


        $notify[] = ['success', "nowPay Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }

    public function fullerwave()
    {
        $data['pageTitle'] = 'Flutterwave';
        $data['navPaymentGatewayActiveClass'] = 'show';
        $data['subNavFlutterPaymentActiveClass'] = 'active';

        $data['gateway'] = Gateway::where('gateway_name', 'flutterwave')->first();

        return view('backend.gateways.flutterwave')->with($data);
    }

    public function fullerwaveUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'flutterwave')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'public_key' => 'required',
            'reference_key' => 'required',
            'rate' => 'required|gt:0',
            'flutter_image' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required'
        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'public_key' => $request->public_key,
            'reference_key' => $request->reference_key
        ];


        if ($gateway) {
            if ($request->hasFile('flutter_image')) {
                $filename = uploadImage($request->flutter_image, gatewayImagePath(), '200x200', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'rate' => $request->rate,
                'status' => $request->status
            ]);


            $notify[] = ['success', "Flutterwave Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('flutter_image')) {
            $filename = uploadImage($request->flutter_image, gatewayImagePath(), '200x200');
        }


        Gateway::create([
            'gateway_name' => 'flutterwave',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'rate' => $request->rate,
            'status' => $request->status
        ]);


        $notify[] = ['success', "Flutterwave Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }

    public function paystack()
    {
        $data['pageTitle'] = 'PayStack';
        $data['navPaymentGatewayActiveClass'] = 'show';
        $data['subNavPayStackPaymentActiveClass'] = 'active';

        $data['gateway'] = Gateway::where('gateway_name', 'paystack')->first();

        return view('backend.gateways.paystack')->with($data);
    }

    public function paystackUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'paystack')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'paystack_key' => 'required',
            'rate' => 'required|gt:0',
            'paystack_image' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required'
        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'paystack_key' => $request->paystack_key,
        ];


        if ($gateway) {
            if ($request->hasFile('paystack_image')) {
                $filename = uploadImage($request->paystack_image, gatewayImagePath(), '200x200', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'rate' => $request->rate,
                'status' => $request->status
            ]);


            $notify[] = ['success', "Paystack Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('paystack_image')) {
            $filename = uploadImage($request->paystack_image, gatewayImagePath(), '200x200');
        }


        Gateway::create([
            'gateway_name' => 'paystack',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'rate' => $request->rate,
            'status' => $request->status
        ]);


        $notify[] = ['success', "Paystack Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }


    public function paytm()
    {
        $data['pageTitle'] = 'Paytm';
        $data['navPaymentGatewayActiveClass'] = 'show';
        $data['subNavpaytmPaymentActiveClass'] = 'active';

        $data['gateway'] = Gateway::where('gateway_name', 'paytm')->first();

        return view('backend.gateways.paytm')->with($data);
    }

    public function paytmUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'paytm')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'merchant_id' => 'required',
            'merchant_key' => 'required',
            'merchant_website' => 'required',
            'merchant_channel' => 'required',
            'merchant_industry' => 'required',
            'rate' => 'required|gt:0',
            'paytm_image' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required'
        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'merchant_id' => $request->merchant_id,
            'merchant_key' => $request->merchant_key,
            'merchant_website' => $request->merchant_website,
            'merchant_channel' => $request->merchant_channel,
            'merchant_industry' => $request->merchant_industry,
            'mode' => $request->mode
        ];


        if ($gateway) {
            if ($request->hasFile('paytm_image')) {
                $filename = uploadImage($request->paytm_image, gatewayImagePath(), '200x200', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'rate' => $request->rate,
                'status' => $request->status
            ]);


            $notify[] = ['success', "PayTm Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('paytm_image')) {
            $filename = uploadImage($request->paytm_image, gatewayImagePath(), '200x200');
        }


        Gateway::create([
            'gateway_name' => 'paytm',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'rate' => $request->rate,
            'status' => $request->status
        ]);


        $notify[] = ['success', "Paytm Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }



    public function paghiper()
    {
        $data['pageTitle'] = 'paghiper';
        $data['navPaymentGatewayActiveClass'] = 'show';
        $data['subNavpaghiperPaymentActiveClass'] = 'active';

        $data['gateway'] = Gateway::where('gateway_name', 'paghiper')->first();

        return view('backend.gateways.paghiper')->with($data);
    }

    public function paghiperUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'paghiper')->first();

        $request->validate([
            'gateway_currency' => 'required',
            'paghiper_key' => 'required',
            'token' => 'required',
            'rate' => 'required|gt:0',
            'paghiper_image' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required'
        ]);

        $data = [
            'gateway_currency' => $request->gateway_currency,
            'paghiper_key' => $request->paghiper_key,
            'token' => $request->token,
        ];


        if ($gateway) {
            if ($request->hasFile('paghiper_image')) {
                $filename = uploadImage($request->paghiper_image, gatewayImagePath(), '200x200', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'rate' => $request->rate,
                'status' => $request->status
            ]);


            $notify[] = ['success', "paghiper Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('paghiper_image')) {
            $filename = uploadImage($request->paghiper_image, gatewayImagePath(), '200x200');
        }


        Gateway::create([
            'gateway_name' => 'paghiper',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'rate' => $request->rate,
            'status' => $request->status
        ]);


        $notify[] = ['success', "paghiper Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }


    public function gourl()
    {
        $data['pageTitle'] = 'GoUrl.io';
        $data['navPaymentGatewayActiveClass'] = 'active';
        $data['subNavgourlPaymentActiveClass'] = 'active';

        $data['currency'] = config('laravel-crypto-payment-gateway.paymentbox');

        $data['gateways'] = Gateway::where('gateway_name','LIKE', '%'.'gourl'.'%')->get();


        return view('backend.gateways.gourl')->with($data);
    }

    public function gourlUpdate(Request $request)
    {
       
        $request->validate([
            'gateway_parameter' => 'required|array',
            'gateway_parameter.*.gateway_currency' => 'required',
            'gateway_parameter.*.public_key' => 'required',
            'gateway_parameter.*.private_key' => 'required',
            'gateway_parameter.*.rate' => 'required|gt:0',
            'gateway_parameter.*.gourl_image' => 'sometimes|mimes:jpg,png,jpeg',
            'status' => 'gateway_parameter.*.required'
        ]);


        foreach ($request->gateway_parameter as $key =>  $params) {


            $gatewayName = 'gourl_'.$key;


            $gateway = Gateway::where('gateway_name', $gatewayName)->first();


            if($gateway){

                if(isset($params['gourl_image'])){

                    $image = uploadImage($params['gourl_image'], gatewayImagePath(), '200x200', $gateway->gateway_image);
                }else{
                    $image = $gateway->gateway_image;
                }

                $gatewayParameters = [
                    'gateway_currency' => $params['gateway_currency'],
                    'public_key' => $params['public_key'],
                    'private_key' => $params['private_key'],
                ];

            }else{
                $gateway = new Gateway();

                $gatewayParameters = [
                    'gateway_currency' => $params['gateway_currency'],
                    'public_key' => $params['public_key'],
                    'private_key' => $params['private_key'],
                ];
                $image = uploadImage($params['gourl_image'], gatewayImagePath());
            }


            $gateway->gateway_name = $gatewayName;
            $gateway->gateway_image = $image;
            $gateway->gateway_parameters = $gatewayParameters;
            $gateway->rate = $params['rate'];

            $gateway->status = $params['status'];


            $gateway->save();


            $this->setEnv([
                strtoupper($gatewayName).'_PUBLIC_KEY' => $gatewayParameters['public_key'],
                strtoupper($gatewayName).'_PRIVATE_KEY' => $gatewayParameters['private_key'],
            ]);
        }




        return redirect()->back()->with('success','Gateway Updated Successfully');



    }


    public function perfectmoney()
    {
        $data['pageTitle'] = 'Perfect Money';
        $data['navPaymentGatewayActiveClass'] = 'active';
        $data['subNavperfectPaymentActiveClass'] = 'active';

        $data['gateway'] = Gateway::where('gateway_name', 'perfectmoney')->first();


        return view('backend.gateways.perfectmoney')->with($data);
    }


    public function perfectmoneyUpdate(Request $request)
    {


        $gateway = Gateway::where('gateway_name', 'perfectmoney')->first();

        $request->validate([
            'accountid' => 'required',
            'passphrase' => 'required',
            'gateway_currency' => 'required',
            'perfectmoney' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required',
            'rate' => 'required|gt:0',
        ]);


        $data = [
            'gateway_currency' => $request->gateway_currency,
            'passphrase' => $request->passphrase,
            'accountid' => $request->accountid,
        ];


        if ($gateway) {
            if ($request->hasFile('perfectmoney')) {
                $filename = uploadImage($request->perfectmoney, gatewayImagePath(), '200x200', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'rate' => $request->rate,
                'status' => $request->status
            ]);


            $notify[] = ['success', "perfectmoney Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('perfectmoney')) {
            $filename = uploadImage($request->perfectmoney, gatewayImagePath(), '200x200');
        }


        Gateway::create([
            'gateway_name' => 'perfectmoney',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'rate' => $request->rate,
            'status' => $request->status
        ]);


        $notify[] = ['success', "perfectmoney Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }


    public function mercadopago()
    {
        $data['pageTitle'] = 'Mercadopago';
        $data['navPaymentGatewayActiveClass'] = 'active';
        $data['subNavperfectPaymentActiveClass'] = 'active';

        $data['gateway'] = Gateway::where('gateway_name', 'mercadopago')->first();


        return view('backend.gateways.mercadopago')->with($data);
    }

    public function mercadopagoUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'mercadopago')->first();

        $request->validate([
            'access_token' => 'required',
            'public_key' => 'required',
            'gateway_currency' => 'required',
            'mercadopago' => [Rule::requiredIf(function () use ($gateway) {
                return $gateway == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'status' => 'required',
            'rate' => 'required|gt:0',
        ]);


        $data = [
            'gateway_currency' => $request->gateway_currency,
            'access_token' => $request->access_token,
            'public_key' => $request->public_key,
        ];


        if ($gateway) {
            if ($request->hasFile('mercadopago')) {
                $filename = uploadImage($request->mercadopago, gatewayImagePath(), '200x200', $gateway->gateway_image);
            }


            $gateway->update([
                'gateway_image' => $filename ?? $gateway->gateway_image,
                'gateway_parameters' => $data,
                'gateway_type' => 1,
                'rate' => $request->rate,
                'status' => $request->status
            ]);


            $notify[] = ['success', "mercadopago Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }


        if ($request->hasFile('mercadopago')) {
            $filename = uploadImage($request->mercadopago, gatewayImagePath(), '200x200');
        }


        Gateway::create([
            'gateway_name' => 'mercadopago',
            'gateway_image' => $filename,
            'gateway_parameters' => $data,
            'gateway_type' => 1,
            'rate' => $request->rate,
            'status' => $request->status
        ]);


        $notify[] = ['success', "mercadopago Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }


    private function setEnv($object)
    {

       
        foreach ($object as $key => $value){
            file_put_contents(app()->environmentFilePath(), str_replace(
                $key . '=' . env($key),
                $key . '=' . $value,
                file_get_contents(app()->environmentFilePath())
            ));
        }

    }

    public function manualPayment(Request $request)
    {
        $data['pageTitle'] = "Manual Payments";
        $data['navManualPaymentActiveClass'] = 'active';

        $manuals = Payment::query();

        if ($request->status == 'pending') {
            $data['subNavPendingPaymentActiveClass'] = 'active';
            $manuals->where('payment_status', 2);
        } elseif ($request->status == 'accepted') {
            $data['subNavAcceptedPaymentActiveClass'] = 'active';
            $manuals->where('payment_status', 1);
        } elseif ($request->status == 'rejected') {
            $data['subNavRejectedPaymentActiveClass'] = 'active';
            $manuals->where('payment_status', 3);
        } else {
            $data['subNavManualPaymentActiveClass'] = 'active';
        }

        $data['manuals'] = $manuals->where('payment_type', 0)->with('user')->latest()->paginate();


        return view('backend.manual_payments.index')->with($data);
    }

    public function manualPaymentDetails(Request $request)
    {
        $pageTitle = "Payment Details";

        $manual = Payment::where('transaction_id', $request->trx)->firstOrFail();

        return view('backend.manual_payments.details', compact('pageTitle', 'manual'));
    }

    public function manualPaymentAccept(Request $request)
    {
        $booking = Payment::where('transaction_id', $request->trx)->firstOrFail();
        $general = GeneralSetting::first();
        $gateway = Gateway::where('gateway_name', 'bank')->first();

        $booking->payment_status = 1;
        $booking->save();

        refferMoney($booking->user_id, $booking->user->refferedBy, 'invest', $booking->amount, $booking->plan->id);


        Transaction::create([
            'trx' => $booking->transaction_id,
            'gateway_id' => $booking->gateway_id,
            'amount' => $booking->amount,
            'currency' => $general->site_currency,
            'details' => 'Payment Successfull',
            'charge' => $gateway->charge,
            'type' => '-',
            'user_id' => $booking->user_id,
            'payment_status' => 1
        ]);


        sendMail('PAYMENT_CONFIRMED', ['trx' => $booking->transaction_id, 'amount' => $booking->amount, 'charge' => number_format($gateway->charge, 4), 'plan' => $booking->plan->plan_name, 'currency' => $general->site_currency], $booking->user);

        $notify[] = ['success', "Payment Confirmed Successfully"];

        return redirect()->back()->withNotify($notify);
    }

    public function manualPaymentReject(Request $request)
    {

        $booking = Payment::where('transaction_id', $request->trx)->firstOrFail();
        $general = GeneralSetting::first();
        $gateway = Gateway::where('gateway_name', 'bank')->first();

        $booking->payment_status = 3;
        $booking->save();

        sendMail('PAYMENT_REJECTED', ['trx' => $booking->transaction_id, 'amount' => $booking->amount, 'charge' => number_format($gateway->charge, 4), 'plan' => $booking->plan->plan_name, 'currency' => $general->site_currency], $booking->user);

        $notify[] = ['success', "Payment Rejected Successfully"];

        return redirect()->back()->withNotify($notify);
    }


    public function depositLog($user = '')
    {
        $user = User::find($user);


        $data['pageTitle'] = "Deposit Log";
        $data['navDepositPaymentActiveClass'] = 'active';

        $manuals = Deposit::query();

        if($user){
            $manuals->where('user_id', $user->id);
        }

        $data['manuals'] = $manuals->where('payment_type', 0)->with('user')->latest()->paginate();


        return view('backend.deposit_log')->with($data);
    }

    public function depositDetails(Request $request)
    {
        $pageTitle = "Payment Details";

        $manual = Deposit::where('transaction_id', $request->trx)->firstOrFail();

        return view('backend.deposit_details', compact('pageTitle', 'manual'));
    }

    public function depositAccept(Request $request)
    {
        $booking = Deposit::where('transaction_id', $request->trx)->firstOrFail();
        $general = GeneralSetting::first();
        $gateway = Gateway::where('gateway_name', 'bank')->first();

        $booking->payment_status = 1;


        $booking->user->balance = $booking->user->balance + $booking->amount;
        $booking->save();
        $booking->user->save();

        Transaction::create([
            'trx' => $booking->transaction_id,
            'gateway_id' => $booking->gateway_id,
            'amount' => $booking->amount,
            'currency' => $general->site_currency,
            'details' => 'Payment Successfull',
            'charge' => $gateway->charge,
            'type' => '-',
            'user_id' => $booking->user_id,
            'payment_status' => 1
        ]);


        sendMail('PAYMENT_CONFIRMED', ['trx' => $booking->transaction_id, 'amount' => $booking->amount, 'charge' => number_format($gateway->charge, 4), 'plan' => 'deposit', 'currency' => $general->site_currency], $booking->user);

        $notify[] = ['success', "Payment Confirmed Successfully"];

        return redirect()->back()->withNotify($notify);
    }

    public function depositReject(Request $request)
    {

        $booking = Deposit::where('transaction_id', $request->trx)->firstOrFail();
        $general = GeneralSetting::first();
        $gateway = Gateway::where('gateway_name', 'bank')->first();

        $booking->payment_status = 3;
        $booking->save();

        sendMail('PAYMENT_REJECTED', ['trx' => $booking->transaction_id, 'amount' => $booking->amount, 'charge' => number_format($gateway->charge, 4), 'plan' => 'deposit', 'currency' => $general->site_currency], $booking->user);

        $notify[] = ['success', "Payment Rejected Successfully"];

        return redirect()->back()->withNotify($notify);
    }
}
