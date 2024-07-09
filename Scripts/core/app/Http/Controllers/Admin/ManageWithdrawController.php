<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\Withdraw;
use App\Models\WithdrawGateway;
use Illuminate\Http\Request;

class ManageWithdrawController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'Withdraw Methods';
        $data['navManageWithdrawActiveClass'] = 'active';
        $data['subNavWithdrawMethodActiveClass'] = 'active';

        $search = $request->search;

        $data['withdraws'] = WithdrawGateway::when($search, function($q) use($search){$q->where('name','LIKE','%'.$search.'%');})->latest()->paginate(10);

        return view('backend.withdraw.index')->with($data);
    }

    public function withdrawMethodCreate (Request $request)
    {

        
        $request->validate([
            'name' => 'required|unique:withdraw_gateways,name',
            'min_amount' => 'required|numeric|gt:0',
            'max_amount' => 'required|numeric|gt:min_amount',
            'charge_type' => 'required|in:fixed,percent',
            'charge' => 'required|numeric',
            'status' => 'required|in:0,1',
            'withdraw_instruction' => 'sometimes'
        ]);

        WithdrawGateway::create([
            'name' => $request->name,
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'charge_type' => $request->charge_type,
            'charge' => $request->charge,
            'status' => $request->status,
            'withdraw_instruction' => $request->withdraw_instruction
        ]);

        $notify[] = ['success', 'Withdraw Method Created'];
        return redirect()->back()->withNotify($notify);
    }

    public function withdrawMethodUpdate (Request $request, WithdrawGateway $method)
    {
        $request->validate([
            'name' => 'required|unique:withdraw_gateways,name,'.$method->id,
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|gt:min_amount',
            'charge_type' => 'required|in:fixed,percent',
            'charge' => 'required|numeric',
            'status' => 'required|in:0,1',
            'withdraw_instruction' => 'sometimes'
        ]);

       $method->update([
            'name' => $request->name,
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'charge_type' => $request->charge_type,
            'charge' => $request->charge,
            'status' => $request->status,
            'withdraw_instruction' => $request->withdraw_instruction
        ]);

        $notify[] = ['success', 'Withdraw Method Updated'];
        return redirect()->back()->withNotify($notify);
    }

    public function withdrawMethodDelete(WithdrawGateway $method)
    {
        $ifPending = $method->withdrawLogs()->where('status',0)->count();

        if($ifPending > 0){
            $notify[] = ['error', 'Withdraw request is pending under this method.'];
            return redirect()->back()->withNotify($notify);
        }

        $method->delete();

        $notify[] = ['success', 'Withdraw Method Deleted Successfully'];
        return redirect()->back()->withNotify($notify);

    }

    public function accepted()
    {
        $data['pageTitle'] = 'Accepted Withdraws';
        $data['navManageWithdrawActiveClass'] = 'active';
        $data['subNavWithdrawAcceptedActiveClass'] = 'active';

        $data['withdrawlogs'] = Withdraw::whereHas('withdrawMethod')->where('status', 1)->latest()->with('withdrawMethod','user')->paginate(10);

        return view('backend.withdraw.withdraw_all')->with($data);
    }
    public function pending()
    {
        $data['pageTitle'] = 'Pending Withdraws';
        $data['navManageWithdrawActiveClass'] = 'active';
        $data['subNavWithdrawPendingActiveClass'] = 'active';

        $data['withdrawlogs'] = Withdraw::whereHas('withdrawMethod')->where('status', 0)->latest()->with('withdrawMethod','user')->paginate(10);

        return view('backend.withdraw.withdraw_all')->with($data);
    }
    public function rejected()
    {
        $data['pageTitle'] = 'Rejected Withdraws';
        $data['navManageWithdrawActiveClass'] = 'active';
        $data['subNavWithdrawRejectedActiveClass'] = 'active';

        $data['withdrawlogs'] = Withdraw::whereHas('withdrawMethod')->where('status', 2)->latest()->with('withdrawMethod','user')->paginate(10);

        return view('backend.withdraw.withdraw_all')->with($data);
    }

    public function withdrawAccept(Withdraw $withdraw)
    {
        $general = GeneralSetting::first();
        $withdraw->status = 1;
        $withdraw->save();

       

        Transaction::create([
            'trx' => $withdraw->transaction_id,
            'user_id' => $withdraw->user->id,
            'gateway_id' => $withdraw->withdrawMethod->id,
            'amount' => $withdraw->withdraw_amount,
            'currency' => $general->site_currency ?? 'USD',
            'charge' => $withdraw->withdraw_charge,
            'details' => 'Withdraw via '.$withdraw->withdrawMethod->name,
            'type' => '-'
        ]);


        sendMail('WITHDRAW_ACCEPTED',['amount'=>$withdraw->withdraw_amount, 'method' => $withdraw->withdrawMethod->name,'currency' => $general->site_currency], $withdraw->user);

        $notify[] = ['success', 'Withdraw Accepted Successfully'];
        return redirect()->back()->withNotify($notify);
    }


    public function withdrawReject(Request $request, Withdraw $withdraw)
    {
       $request->validate(['reason_of_reject' => 'required']);

        $general = GeneralSetting::first();
        $withdraw->status = 2;
        $withdraw->reason_of_reject = $request->reason_of_reject;
        $withdraw->save();

        $withdraw->user->balance = $withdraw->user->balance + $withdraw->withdraw_amount;
        $withdraw->user->save();

        Transaction::create([

            'trx' => $withdraw->transaction_id,
            'user_id' => $withdraw->user->id,
            'gateway_id' => $withdraw->withdrawMethod->id,
            'amount' => $withdraw->withdraw_amount,
            'currency' => $general->site_currency ?? 'USD',
            'charge' => $withdraw->withdraw_charge,
            'details' => 'Rejected Withdraw via '.$withdraw->withdrawMethod->name,
            'type' => '-'
        ]);

        sendMail('WITHDRAW_REJECTED',['amount'=>$withdraw->withdraw_amount, 'method' => $withdraw->withdrawMethod->name,'currency' => $general->site_currency,'reason' => $withdraw->reason_of_reject], $withdraw->user);

        $notify[] = ['success', 'Withdraw Rejected Successfully'];
        return redirect()->back()->withNotify($notify);

    }
}
