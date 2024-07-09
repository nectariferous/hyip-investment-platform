<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\GeneralSetting;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Transaction;
use App\Notifications\DepositNotification;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct()
    {
        $general = GeneralSetting::first();
        $this->template = $general->theme == 1 ? 'frontend.' : "theme{$general->theme}.";
    }


    public function gateways(Request $request, $id)
    {

        $plan = Plan::findOrFail($id);

        $general = GeneralSetting::first();

        $plan_exist = Payment::where('plan_id', $id)->where('user_id', Auth::id())->where('next_payment_date', '!=', null)->where('payment_status', 1)->count();

        if ($plan_exist < $plan->invest_limit) {

            $gateways = Gateway::where('status', 1)->latest()->get();

            $pageTitle = "Payment Methods";

            return view($this->template . "user.gateway.gateways", compact('gateways', 'pageTitle', 'plan'));
        }

        return redirect()->back()->with('error', 'Max Invest Limit exceeded');
    }

    public function paynow(Request $request)
    {
        $request->validate([
            'amount' => 'required|gte:0',
        ]);

        $gateway = Gateway::where('status', 1)->findOrFail($request->id);
        $trx = strtoupper(Str::random());
        $final_amount = ($request->amount * $gateway->rate) + $gateway->charge;

        if (isset($request->type) && $request->type == 'deposit') {

            $deposit = Deposit::create([
                'gateway_id' => $gateway->id,
                'user_id' => auth()->id(),
                'transaction_id' => $trx,
                'amount' => $request->amount,
                'rate' => $gateway->rate,
                'charge' => $gateway->charge,
                'final_amount' => $final_amount,
                'payment_status' => 0,
                'payment_type' => 1,
            ]);

            session()->put('trx', $trx);
            session()->put('type', 'deposit');


            return redirect()->route('user.gateway.details', $gateway->id);
        }



        $plan_id = Plan::with('time')->findOrFail($request->plan_id);

        if ($plan_id->amount_type == 0) {
            if ($plan_id->maximum_amount) {
                if ($request->amount > $plan_id->maximum_amount) {
                    return redirect()->back()->with('error', 'Maximum Invest Limit ' . number_format($plan_id->maximum_amount, 2));
                }
            }

            if ($plan_id->minimum_amount) {
                if ($request->amount < $plan_id->minimum_amount) {
                    return redirect()->back()->with('error', 'Minimum Invest Limit ' . number_format($plan_id->minimum_amount, 2));
                }
            }
        }

        if ($plan_id->amount_type == 1) {

            if ($plan_id->amount) {
                if ($request->amount != $plan_id->amount) {
                    return redirect()->back()->with('error', 'Fixed Invest Limit ' . number_format($plan_id->amount, 2));
                }
            }
        }

        $next_payment_date = Carbon::now()->addHours($plan_id->time->time);

        $payment = Payment::create([
            'plan_id' => $plan_id->id,
            'gateway_id' => $gateway->id,
            'user_id' => auth()->id(),
            'transaction_id' => $trx,
            'amount' => $request->amount,
            'rate' => $gateway->rate,
            'charge' => $gateway->charge,
            'final_amount' => $final_amount,
            'payment_status' => 0,
            'next_payment_date' => $next_payment_date,

        ]);




        session()->put('trx', $trx);
        session()->forget('type');

        return redirect()->route('user.gateway.details', $gateway->id);
    }

    public function gatewaysDetails($id)
    {


        $gateway = Gateway::where('status', 1)->findOrFail($id);

        $general = GeneralSetting::first();

        if (session('type') == 'deposit') {
            $deposit = Deposit::where('transaction_id', session('trx'))->firstOrFail();
        } else {

            $deposit = Payment::where('transaction_id', session('trx'))->firstOrFail();
        }

        $pageTitle = $gateway->gateway_name . ' Payment Details';


        if ($gateway->gateway_name == 'vouguepay') {

            $vouguePayParams["marchant_id"] = $gateway->gateway_parameters->vouguepay_merchant_id;
            $vouguePayParams["redirect_url"] = route("user.vouguepay.redirect");
            $vouguePayParams["currency"] = $gateway->gateway_parameters->gateway_currency;
            $vouguePayParams["merchant_ref"] = $deposit->transaction_id;
            $vouguePayParams["memo"] = "Payment";
            $vouguePayParams["store_id"] = $deposit->user_id;
            $vouguePayParams["loadText"] = $deposit->transaction_id;
            $vouguePayParams["amount"] = $deposit->final_amount;
            $vouguePayParams = json_decode(json_encode($vouguePayParams));

            return view($this->template . "user.gateway.{$gateway->gateway_name}", compact('gateway', 'pageTitle', 'deposit', 'vouguePayParams'));
        }

        if ($gateway->is_created) {


            return view($this->template . "user.gateway.gateway_manual", compact('gateway', 'pageTitle', 'deposit'));
        }


        if (strstr($gateway->gateway_name, 'gourl')) {
            return view($this->template . "user.gateway.gourl", compact('gateway', 'pageTitle', 'deposit'));
        }

        return view($this->template . "user.gateway.{$gateway->gateway_name}", compact('gateway', 'pageTitle', 'deposit'));
    }

    public function gatewayRedirect(Request $request, $id)
    {

        $gateway = Gateway::where('status', 1)->findOrFail($id);

        if (session('type') == 'deposit') {
            $deposit = Deposit::where('transaction_id', session('trx'))->firstOrFail();
        } else {

            $deposit = Payment::where('transaction_id', session('trx'))->firstOrFail();
        }

        if ($gateway->is_created) {

            $new = __NAMESPACE__ . '\\Gateway\\' . 'manual\ProcessController';
        } else {

            if (strstr($gateway->gateway_name, 'gourl')) {
                $new = __NAMESPACE__ . '\\Gateway\\' . 'gourl' . '\ProcessController';
            } else {
                $new = __NAMESPACE__ . '\\Gateway\\' . $gateway->gateway_name . '\ProcessController';
            }
        }


        $data = $new::process($request, $gateway, $deposit->final_amount, $deposit);

        if ($gateway->gateway_name == 'mercadopago' ) {
            return redirect()->to($data['redirect_url']);
        }
        


        if (strstr($gateway->gateway_name, 'gourl')) {
            return redirect()->to($data);
        }

        if ($gateway->gateway_name == 'nowpayments') {

            return redirect()->to($data->invoice_url);
        }

        if ($gateway->gateway_name == 'mollie') {

            return redirect()->to($data['redirect_url']);
        }

        if ($gateway->gateway_name == 'paghiper') {

            if (isset($data['status']) && $data['status'] == false) {
                return redirect()->route('user.investmentplan')->with('error', 'Something Went Wrong');
            }

            return redirect()->to($data);
        }

        if ($gateway->gateway_name == 'coinpayments') {

         
                return view($data['view'])->with($data);
            
        }

        if ($gateway->gateway_name == 'paypal') {

            $data = json_decode($data);

            return redirect()->to($data->links[1]->href);
        }
        if ($gateway->gateway_name == 'paytm') {

            return view($this->template.'user.gateway.auto',compact('data'));
        }

        $notify[] = ['success', 'Your Payment is Successfully Recieved'];
        return redirect()->route('user.dashboard')->withNotify($notify);
    }

    public static function updateUserData($deposit, $fee_amount, $transaction)
    {

        $general = GeneralSetting::first();

        $admin = Admin::first();

        $user = auth()->user();

        if (session('type') == 'deposit') {
            $user->balance = $user->balance + $deposit->amount;

            $user->save();

            $admin->notify(new DepositNotification($user, $deposit));
        }

        $deposit->payment_status = 1;

        $deposit->save();

        if (!(session('type') == 'deposit')) {
           
            refferMoney(auth()->id(), $deposit->user->refferedBy, 'invest', $deposit->amount, $deposit->plan->id);
        }

        session()->forget('type');

        Transaction::create([
            'trx' => $deposit->transaction_id,
            'gateway_id' => $deposit->gateway_id,
            'amount' => $deposit->amount,
            'currency' => @$general->site_currency,
            'details' => 'Payment Successfull',
            'charge' => $fee_amount,
            'type' => '-',
            'gateway_transaction' => $transaction,
            'user_id' => auth()->id(),
            'payment_status' => 1,
        ]);

        sendMail('PAYMENT_SUCCESSFULL', [
            'plan' => $deposit->plan->plan_name ?? 'Deposit',
            'trx' => $transaction,
            'amount' => $deposit->amount,
            'currency' => $general->site_currency,
        ], $deposit->user);
    }
}