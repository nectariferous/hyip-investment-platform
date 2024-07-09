<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\MoneyTransfer;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\WithdrawGateway;
use App\Notifications\DepositNotification;
use App\Notifications\NewUserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function dashboard()
    {
        $data['pageTitle'] = 'Dashboard';
        $data['navDashboardActiveClass'] = "active";

        $data['totalPayments'] = Payment::where('payment_status', 1)->sum('final_amount');
        $data['totalPendingPayments'] = Payment::where('payment_status', 0)->sum('final_amount');
        $data['totalWithdraw'] = Withdraw::where('status', 1)->sum('withdraw_amount');

        $data['totalUser'] = User::count();

        $data['activeUser'] = User::where('status', 1)->count();

        $data['deActiveUser'] = User::where('status', 0)->count();

        $months = collect([]);
        $totalAmount = collect([]);
        $data['users'] = User::latest()->paginate(5);
        Payment::where('payment_status', 1)
            ->select(DB::raw('SUM(final_amount) as total'), DB::raw('MONTHNAME(created_at) month'))
            ->groupby('month')
            ->get()
            ->map(function ($q) use ($months, $totalAmount) {
                $months->push($q->month);
                $totalAmount->push($q->total);
            });

        $data['months'] = $months;
        $data['totalAmount'] = $totalAmount;

        $withdrawMonths = collect([]);
        $withdrawTotalAmount = collect([]);
        Withdraw::where('status', 1)
            ->select(DB::raw('SUM(withdraw_amount) as total'), DB::raw('MONTHNAME(created_at) month'))
            ->groupby('month')
            ->get()
            ->map(function ($q) use ($withdrawMonths, $withdrawTotalAmount) {
                $withdrawMonths->push($q->month);
                $withdrawTotalAmount->push($q->total);
            });

        $data['withdrawMonths'] = $withdrawMonths;
        $data['withdrawTotalAmount'] = $withdrawTotalAmount;
        $data['totalGateways'] = Gateway::where('gateway_name', '!=', 'bank')->count();
        $data['totalWithdrawCharge'] = Withdraw::where('status', 1)->sum('withdraw_charge');
        $data['totalWithdrawGateways'] = WithdrawGateway::where('status', 1)->count();
        $data['totalInterest'] = Payment::where('payment_status', 1)->sum('interest_amount');
        $data['pendignWithdraw'] = Withdraw::where('status', 0)->sum('withdraw_amount');
        


        return view('backend.dashboard')->with($data);
    }

    public function transaction(Request $request, $user = '')
    {

        $user = User::find($user);

        $data['pageTitle'] = 'Transaction Log';
        $data['navReportActiveClass'] = 'active';
        $data['subNavTransactionActiveClass'] = 'active';


        $dates = array_map(function ($date) {
            return Carbon::parse($date);
        }, explode('-', $request->dates));

        $transactions = Transaction::query();

        if($user){
            $transactions->where('user_id', $user->id);
        }


        $data['transactions'] = $transactions->when($request->dates, function ($q) use ($dates) {
            $q->whereBetween('created_at', $dates);
        })->where('payment_status', 1)->latest()->paginate();

        $data['gateways'] = Gateway::where('status', 1)->get();

        $data['plans'] = Plan::where('status', 1)->get();

        return view('backend.transaction')->with($data);
    }

    public function markNotification(Request $request)
    {
        auth()->guard('admin')->user()
            ->unreadNotifications()
            ->where('type', NewUserNotification::class)
            ->get()
            ->markAsRead();

        return redirect()->back()->with('success', 'All Notifications are Marked');
    }

    public function markDepositNotification(Request $request)
    {
        auth()->guard('admin')->user()
            ->unreadNotifications()
            ->where('type',DepositNotification::class)
            ->get()
            ->markAsRead();

        return redirect()->back()->with('success', 'All Notifications are Marked');
    }

    public function subscribers(){

        $pageTitle="Newsletter Subscriber";
        $subscribers=Subscriber::latest()->paginate();
        return view ('backend.subscriber',compact('subscribers','pageTitle'));
    }

    public function MoneyTransfer(Request $request)
    {
        $data['transfers'] = MoneyTransfer::when($request->trx, function ($item) use ($request) {
            $item->where('transaction_id', $request->trx);
        })->when($request->date, function ($item) use ($request) {
            $item->whereDate('created_at', $request->date);
        })->where('sender_id', auth()->id())->latest()->with('sender', 'receiver')->paginate();

        $data['pageTitle'] = 'Money Transfer Log';

        return view('backend.report.money_transfer')->with($data);
    }

    public function updateSystem()
    {
        if(!file_exists(base_path().'/update/up1/update.json')){
            return redirect()->back()->with('error','No directory Found');
        }
        
        
        $updatePath = base_path();
        


        $json = json_decode(file_get_contents(base_path().'/update/up1/update.json'), true);
        

         if (!empty($json['files'])) {
            foreach ($json['files'] as $file) {

                copy($updatePath.'/'.$file['root_directory'] , base_path($file['update_directory']));
            }
        }
        
        

        if (!empty($json['folder'])) {

            foreach ($json['folder'] as $directory) {
                File::copyDirectory($updatePath.'/'.$json['root_directory'], base_path($directory['update_directory']));
            }
        }

        if (!empty($json['directory'])) {

            foreach ($json['directory'][0]['name'] as $directory) {
                makeDirectory(base_path($directory));
            }
        }

       


        return redirect()->back()->with('success','System Updated Successfully');
    }
    
    public function updateDb()
    {

        $sql_path = base_path().'/update/up1/up1.sql';

        DB::unprepared(file_get_contents($sql_path));

        return redirect()->back()->with('success', 'successfully update database');
    }
}
