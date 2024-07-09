<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Subscriber;



class DashboardController extends Controller
{
    public function __construct()
    {
        $general = GeneralSetting::first();
        $this->template = $general->theme == 1 ? 'frontend.' : "theme{$general->theme}.";
    }


    public function investment()
    {
        $plan = Plan::with('time')->latest()->where('status', 1)->where('featured', 1)->get();
        return view($this->template.'dashboard.investment', compact('plan'));
    }

    public function investmentCalculate(Request $request, $id)
    {


        $request->validate([
            'amount' => 'required|gte:0|numeric',
            'selectplan' => 'required'
        ],[
            'selectplan.required'=>'please select a plan'
        ]);


        $plan = Plan::with('time')->find($id);

        $amount = $request->amount;

        //check max-min amount
        if ($plan->amount_type == 0) {
            if ($plan->maximum_amount) {
                if ($amount > $plan->maximum_amount) {
                    return response()->json([
                        'message' => 'Maximum invest limit',
                        'amount' => $plan->maximum_amount,
                    ]);
                }
            }

            if ($plan->minimum_amount) {
                if ($amount < $plan->minimum_amount) {
                    return response()->json([
                        'message' => 'Minimum invest limit',
                        'amount' => $plan->minimum_amount,
                    ]);
                }
            }
        }

        //fixed check
        if ($plan->amount_type == 1) {
            if ($plan->amount) {
                if ($amount != $plan->amount) {
                    return response()->json([
                        'message' => 'Fixed invest',
                        'amount' => $plan->amount,
                    ]);
                }
            }
        }


        if ($plan->interest_status == 'percentage') {
            $calculate = $amount * $plan->return_interest / 100;
            return view($this->template.'pages.profittable', compact('plan', 'calculate', 'amount'));
        }

        if ($plan->interest_status == 'fixed') {


            $calculate = $plan->return_interest;

            return view($this->template.'pages.profittable', compact('plan', 'calculate', 'amount'));
        }
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers',
        ]);

        Subscriber::create([
            'email' => $request->email
        ]);

        return response()->json([
            'message' => 'newsletter subscription is successful',
        ]);
    }
}
