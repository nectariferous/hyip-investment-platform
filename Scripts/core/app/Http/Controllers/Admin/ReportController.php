<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\Withdraw;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function paymentReport(Request $request, $user = '')
    {
        $user = User::find($user);
        $data['pageTitle'] = 'Payment Report';
        $data['navReportActiveClass'] = 'active';
        $data['subNavPaymentReportActiveClass'] = 'active';

        $transactions = Payment::where('payment_status', 1);

        if($user){
            $transactions->where('user_id', $user->id);
        }

        if ($request->ajax()) {

            $transactions = $this->ajaxFilter($transactions, $request);

            return view('backend.report.payment_ajax', compact('transactions'));
        }

        $data['transactions'] = $transactions->latest()->paginate();

        return view('backend.report.payment_report')->with($data);
    }


    public function withdarawReport(Request $request, $user= '')
    {
        $user = User::find($user);
        $data['pageTitle'] = 'Withdraw Report';
        $data['navReportActiveClass'] = 'active';
        $data['subNavWithdrawReportActiveClass'] = 'active';

        
        $data['transactions'] = Withdraw::where('status', 1);
        
        if($user){
            $data['transactions']->where('user_id', $user->id);
        }
        if ($request->ajax()) {

            $data['transactions'] = $this->ajaxFilter($data['transactions'], $request);

            return view('backend.report.withdraw_ajax')->with($data);
        }

        $data['transactions'] = $data['transactions']->latest()->paginate();

        return view('backend.report.withdraw_report')->with($data);
    }


    public function ajaxFilter($transactions, $request)
    {
        return $transactions->when($request->key, function ($query) use ($request) {
            if ($request->key === 'Today') {
                $query->whereDate('created_at', now());
            } elseif ($request->key === 'Yesterday') {
                $query->whereDate('created_at', now()->subDay());
            } elseif ($request->key === 'Last 7 Days') {
                $query->whereDate('created_at', '>=', now()->subDays(7));
            } elseif ($request->key === 'Last 30 Days') {
                $query->whereDate('created_at', '>=', now()->subDays(30));
            } elseif ($request->key === 'This Month') {
                $query->whereMonth('created_at', now());
            } else {
                $startdate = Carbon::parse($request->startdate);
                $enddate = Carbon::parse($request->dateEnd);

                $query->whereBetween('created_at', [$startdate, $enddate]);
            }
        })->latest()->get();
    }
}
