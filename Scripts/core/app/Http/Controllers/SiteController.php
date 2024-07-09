<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Plan;
use App\Models\SectionData;
use App\Models\Comment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Auth;
use App;
use App\Models\GeneralSetting;
use App\Models\MoneyTransfer;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SiteController extends Controller
{

    public function __construct()
    {
        $general = GeneralSetting::first();
        $this->template = $general->theme == 1 ? 'frontend.' : "theme{$general->theme}.";
    }


    public function index()
    {

        $pageTitle = 'Home';

        $sections = Page::where('name', 'home')->first();

        if (!$sections) {

            $sections = Page::create([
                'name' => 'home',
                'sections' => ['about'],
                'slug' => 'home',
                'seo_description' => 'home',
                'page_order' => 1
            ]);
        }

        $plan = Plan::where('status', 1)->get();

        return view($this->template . 'home', compact('pageTitle', 'sections', 'plan'));
    }

    public function page(Request $request)
    {

        $page = Page::where('slug', $request->pages)->first();

        if (!$page) {
            abort(404);
        }

        $pageTitle = "{$page->name}";

        return view($this->template . 'pages', compact('pageTitle', 'page'));
    }


    public function contactSend(Request $request)
    {

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        sendGeneralMail($data);

        $notify[] = ['success', 'Contact With us successfully'];

        return back()->withNotify($notify);
    }



    public function investmentPlan()
    {
        $pageTitle = "Investment Plan";
        $plans = Plan::where('status', 1)->get();
        return view($this->template . 'pages.invest', compact('pageTitle', 'plans'));
    }

    public function investmentUsingBalannce(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric'
        ]);

        $general = GeneralSetting::first();

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

        $trx = strtoupper(Str::random());


        $user = auth()->user();


        if ($user->balance < $request->amount) {
            return redirect()->back()->with('error', 'You dont have sufficient balance to invest');
        }

        $user->balance = $user->balance - $request->amount;
        $user->save();

        $deposit = Payment::create([
            'plan_id' => $plan_id->id,
            'gateway_id' => 0,
            'user_id' => auth()->id(),
            'transaction_id' => $trx,
            'amount' => $request->amount,
            'rate' => 0,
            'charge' => 0,
            'final_amount' => $request->amount,
            'payment_status' => 1,
            'next_payment_date' => $next_payment_date,

        ]);


        refferMoney($deposit->user->id, $deposit->user->refferedBy, 'invest', $deposit->amount, $deposit->plan->id);



        Transaction::create([
            'trx' => $deposit->transaction_id,
            'gateway_id' => $deposit->gateway_id,
            'amount' => $deposit->final_amount,
            'currency' => @$general->site_currency,
            'details' => 'Payment Successfull',
            'charge' => 0,
            'type' => '-',
            'gateway_transaction' => '',
            'user_id' => auth()->id(),
            'payment_status' => 1,
        ]);

        sendMail('PAYMENT_SUCCESSFULL', [
            'plan' => $deposit->plan->plan_name,
            'trx' => $deposit->transaction_id,
            'amount' => $deposit->amount,
            'currency' => $general->site_currency,
        ], $deposit->user);

        return redirect()->route('user.dashboard')->with('success', 'Successfully Invest');
    }


    public function service($slug)
    {

        $pageTitle = "Our Service";
        $data = SectionData::where('key', 'service.element')->whereJsonContains('data->slug', $slug)->first();

        return view($this->template . 'pages.service', compact('pageTitle', 'data'));
    }

    public function blog($id)
    {
        $theme = GeneralSetting::first()->theme;

        $pageTitle = "Recent Blog";
        $data = SectionData::where('theme', $theme)->where('key', 'blog.element')->where('id', $id)->firstOrFail();
        $comments = Comment::with('user')->where('blog_id', $id)->latest()->paginate();
        $recentblog = SectionData::where('theme', $theme)->where('key', 'blog.element')->latest()->limit(6)->paginate();
        return view($this->template . 'pages.blog', compact('pageTitle', 'data', 'comments', 'recentblog'));
    }

    public function blogComment(Request $request, $id)
    {

        $request->validate([
            'comment' => 'required'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'blog_id' => $id,
            'comment' => $request->comment
        ]);

        $notify[] = ['success', 'Comment Post Successfully'];

        return back()->withNotify($notify);
    }


    public function allInvestmentPlan()
    {
        $pageTitle = "Investment Plan";
        $plans = Plan::where('status', 1)->get();
        return view($this->template . 'pages.investmentplan', compact('pageTitle', 'plans'));
    }


    public function privacyPolicy()
    {
        $pageTitle = "Privacy Policy";
        return view($this->template . 'pages.privacypolicy', compact('pageTitle'));
    }

    public function allblog()
    {
        $theme = GeneralSetting::first()->theme;

        $pageTitle = 'Blog';
        $blogs = SectionData::where('theme', $theme)->where('key', 'blog.element')->paginate(6);
        return view($this->template . 'pages.allblog', compact('pageTitle', 'blogs'));
    }
    public function changeLang(Request $request)
    {
        App::setLocale($request->lang);

        session()->put('locale', $request->lang);

        return redirect()->back()->with('success', __('Successfully Changed Language'));
    }

    public function investLog(Request $request)
    {
        $pageTitle = 'Invest Log';

        $transactions = Payment::when($request->trx, function ($item) use ($request) {
            $item->where('transaction_id', $request->trx);
        })->when($request->date, function ($item) use ($request) {
                $item->whereDate('created_at', $request->date);
            })->where('user_id', auth()->id())->where('payment_status', 1)->paginate();

        return view($this->template . 'user.invest_log', compact('pageTitle', 'transactions'));
    }

    public function MoneyTransfer(Request $request)
    {
        $data['transfers'] = MoneyTransfer::when($request->trx, function ($item) use ($request) {
            $item->where('transaction_id', $request->trx);
        })->when($request->date, function ($item) use ($request) {
            $item->whereDate('created_at', $request->date);
        })->where('sender_id', auth()->id())->latest()->with('sender', 'receiver')->paginate();

        $data['pageTitle'] = 'Money Transfer Log';

        return view($this->template . 'user.transfer_log')->with($data);
    }

    public function viewall(Request $request)
    {
        $data['pageTitle'] = 'View All';
        return view($this->template . 'pages.viewall')->with($data);
    }
}
