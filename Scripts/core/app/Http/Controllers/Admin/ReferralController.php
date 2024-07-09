<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\Refferal;
use App\Models\RefferedCommission;
use App\Models\User;

class ReferralController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Referral';

        $referrals = Refferal::latest()->get();

        $plans = Plan::whereStatus(true)->get();


        return view('backend.referral.index', compact('pageTitle','referrals','plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:invest,interest',
            'level' => 'required',
            'commision' => 'required',
            'plan_id' => 'required'
        ]);


        $refferal = Refferal::where('plan_id', $request->plan_id)->where('type', $request->type)->first();


        if($refferal){
            $notify[] = ['error', 'Already Has a Referral'];

            return redirect()->route('admin.referral.index')->withNotify($notify);
        }

        Refferal::create([
            'plan_id' => $request->plan_id,
            'type' => $request->type,
            'level' => $request->level,
            'commision' => $request->commision,
        ]);


        $notify[] = ['success', 'Referral Created Successfully'];

        return redirect()->route('admin.referral.index')->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:invest,interest',
            'level' => 'required',
            'commision' => 'required',
            'plan_id' => 'required'
        ]);


        $refferal = Refferal::findOrFail($id);


        $refferal->update([
            'plan_id' => $request->plan_id,
            'type' => $request->type,
            'level' => $request->level,
            'commision' => $request->commision,
        ]);


        $notify[] = ['success', 'Referral updated Successfully'];

        return redirect()->route('admin.referral.index')->withNotify($notify);
    }


    public function investStore(Request $request)
    {



        Refferal::updateOrCreate([
            'id'=>2
        ],[
            'type' => $request->type,
            'level' => $request->level,
            'commision' => $request->commision,
        ]);

        $notify[] = ['success', 'Invest Commision Created Successfully'];

        return redirect()->route('admin.referral.index')->withNotify($notify);
    }

    public function interestStore(Request $request)
    {
        Refferal::updateOrCreate([
            'id'=>3
        ],[
            'type' => $request->type,
            'level' => $request->level,
            'commision' => $request->commision,
        ]);

        $notify[] = ['success', 'Interest Commision Created Successfully'];

        return redirect()->route('admin.referral.index')->withNotify($notify);
    }


    public function refferalStatusChange(Request $request)
    {
        $refferal = Refferal::findOrFail($request->id);

        if ($request->status) {
            $refferal->status = false;
        } else {
            $refferal->status = true;
        }

        $refferal->save();

        $notify = ['success' => 'Plan Status Change Successfully'];

        return response($notify);
    }

    public function Commision($user = '')
    {
        $user = User::find($user);

        $commison = RefferedCommission::query();

        if($user){
            $commison->where('reffered_by', $user->id);
        }
        
        $commison = $commison->latest()->paginate();

        $pageTitle = 'Commission Log';

        return view('backend.report.commission',compact('commison','pageTitle'));
    }
}
