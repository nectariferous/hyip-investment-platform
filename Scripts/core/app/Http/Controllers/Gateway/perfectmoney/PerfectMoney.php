<?php

namespace App\Http\Controllers\Gateway\perfectmoney;

use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class PerfectMoney
 */
class PerfectMoney
{

    /**
     * @var string
     */
    protected $account_id;

    /**
     * @var string
     */
    protected $passphrase;

    /**
     * @var string
     */
    protected $alt_passphrase;

    /**
     * @var string
     */
    protected $marchant_id;

    /**
     * @var array
     */
    protected $ssl_fix = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]];


    public function __construct()
    {
        $this->account_id = config('perfectmoney.account_id');
        $this->passphrase = config('perfectmoney.passphrase');
        $this->alt_passphrase = config('perfectmoney.alternate_passphrase');
        $this->marchant_id = config('perfectmoney.marchant_id');
    }

    /**
     * get the balance for the wallet
     *
     * @return array
     */
    public function getBalance()
    {

        // Get data from the server
        $url = file_get_contents('https://perfectmoney.is/acct/balance.asp?AccountID=' . $this->account_id . '&PassPhrase=' . $this->passphrase, false, stream_context_create($this->ssl_fix));
        if (!$url) {
            return ['status' => 'error', 'message' => 'Connection error'];
        }

        // searching for hidden fields
        if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $url, $result, PREG_SET_ORDER)) {
            return ['status' => 'error', 'message' => 'Invalid output'];
        }

        // putting data to array (return error, if have any)
        $data = [];
        foreach ($result as $item) {
            if ($item[1] == 'ERROR') {
                return ['status' => 'error', 'message' => $item[2]];
            } else {
                $data['balance'] = [
                    'currency' => $item[1],
                    'balance' => $item[2]
                ];
            }
        }

        $data['status'] = 'success';

        return $data;
    }

    /**
     * Send Money
     *
     * @param string $account
     * @param double $amount
     * @param string $descripion
     * @param string $payment_id
     *
     * @return array
     */
    public function sendMoney($account, $amount, $descripion = '', $payment_id = '')
    {

        // trying to open URL to process PerfectMoney Spend request
        $url = file_get_contents('https://perfectmoney.is/acct/confirm.asp?AccountID=' . urlencode(trim($this->account_id)) . '&PassPhrase=' . urlencode(trim($this->passphrase)) . '&Payer_Account=' . urlencode(trim($this->marchant_id)) . '&Payee_Account=' . urlencode(trim($account)) . '&Amount=' . $amount . (empty($descripion) ? '' : '&Memo=' . urlencode(trim($descripion))) . (empty($payment_id) ? '' : '&PAYMENT_ID=' . urlencode(trim($payment_id))), false, stream_context_create($this->ssl_fix));

        if (!$url) {
            return ['status' => 'error', 'message' => 'Connection error'];
        }

        // searching for hidden fields
        if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $url, $result, PREG_SET_ORDER)) {
            return ['status' => 'error', 'message' => 'Invalid output'];
        }

        // putting data to array (return error, if have any)
        $data = [];
        foreach ($result as $item) {
            if ($item[1] == 'ERROR') {
                return ['status' => 'error', 'message' => $item[2]];
            } else {
                $data['data'][$item[1]] = $item[2];
            }
        }


        $data['status'] = 'success';

        return $data;
    }

    /**
     * Render form
     *
     * @param array $data
     *
     * @return \Illuminate\View\View
     */
    public static function render($data = [], $view = 'perfectmoney')
    {
        $view_data = [
            'PAYEE_ACCOUNT' => (isset($data['PAYEE_ACCOUNT']) ? $data['PAYEE_ACCOUNT'] : config('perfectmoney.marchant_id')),
            'PAYEE_NAME' => (isset($data['PAYEE_NAME']) ? $data['PAYEE_NAME'] : config('perfectmoney.marchant_name')),
            'PAYMENT_AMOUNT' => (isset($data['PAYMENT_AMOUNT']) ? $data['PAYMENT_AMOUNT'] : ''),
            'PAYMENT_UNITS' => (isset($data['PAYMENT_UNITS']) ? $data['PAYMENT_UNITS'] : config('perfectmoney.units')),
            'PAYMENT_ID' => (isset($data['PAYMENT_ID']) ? $data['PAYMENT_ID'] : null),
            'PAYMENT_URL' => (isset($data['PAYMENT_URL']) ? $data['PAYMENT_URL'] : config('perfectmoney.payment_url')),
            'NOPAYMENT_URL' => (isset($data['NOPAYMENT_URL']) ? $data['NOPAYMENT_URL'] : config('perfectmoney.nopayment_url')),
        ];

        // Status URL
        $view_data['STATUS_URL'] = null;
        if (config('perfectmoney.status_url') || isset($data['STATUS_URL'])) {
            $view_data['STATUS_URL'] = (isset($data['STATUS_URL']) ? $data['STATUS_URL'] : config('perfectmoney.status_url'));
        }

        // Payment URL Method
        $view_data['PAYMENT_URL_METHOD'] = null;
        if (config('perfectmoney.payment_url_method') || isset($data['PAYMENT_URL_METHOD'])) {
            $view_data['PAYMENT_URL_METHOD'] = (isset($data['PAYMENT_URL_METHOD']) ? $data['PAYMENT_URL_METHOD'] : config('perfectmoney.payment_url_method'));
        }

        // No Payment URL Method
        $view_data['NOPAYMENT_URL_METHOD'] = null;
        if (config('perfectmoney.nopayment_url_method') || isset($data['NOPAYMENT_URL_METHOD'])) {
            $view_data['NOPAYMENT_URL_METHOD'] = (isset($data['NOPAYMENT_URL_METHOD']) ? $data['NOPAYMENT_URL_METHOD'] : config('perfectmoney.nopayment_url_method'));
        }

        // Memo
        $view_data['MEMO'] = null;
        if (config('perfectmoney.suggested_memo') || isset($data['SUGGESTED_MEMO'])) {
            $view_data['MEMO'] = (isset($data['SUGGESTED_MEMO']) ? $data['SUGGESTED_MEMO'] : config('perfectmoney.suggested_memo'));
        }

        // Custom view
        if (view()->exists('laravelperfectmoney::' . $view)) {
            return view('laravelperfectmoney::' . $view, $view_data);
        }


        // Default view
        return view('laravelperfectmoney::perfectmoney', $view_data);
    }


    /**
     * This script demonstrates querying account history
     * using PerfectMoney API interface.
     *
     * @param int $start_day
     * @param int $start_month
     * @param int $end_year
     * @param int $end_day
     * @param int $end_month
     * @param int $end_year
     *
     * @return array
     */
    public function getHistory($start_day = null, $start_month = null, $start_year = null, $end_day = null, $end_month = null, $end_year = null, $data = [])
    {
        $start_day = ($start_day ? $start_day : Carbon::now()->subYear()->day);
        $start_month = ($start_month ? $start_month : Carbon::now()->subYear()->month);
        $start_year = ($start_year ? $start_year : Carbon::now()->subYear()->year);
        $end_day = ($end_day ? $end_day : Carbon::now()->day);
        $end_month = ($end_month ? $end_month : Carbon::now()->month);
        $end_year = ($end_year ? $end_year : Carbon::now()->year);


        $url = 'https://perfectmoney.is/acct/historycsv.asp?startmonth=' . $start_month . '&startday=' . $start_day . '&startyear=' . $start_year . '&endmonth=' . $end_month . '&endday=' . $end_day . '&endyear=' . $end_year . '&AccountID=' . urlencode(trim($this->account_id)) . '&PassPhrase=' . urlencode(trim($this->passphrase));

        // Custom Filters
        if (isset($data['payment_id'])) {
            $url .= '&payment_id=' . $data['payment_id'];
        }

        // Custom Filters
        if (isset($data['batchfilter'])) {
            $url .= '&batchfilter=' . $data['batchfilter'];
        }

        if (isset($data['counterfilter'])) {
            $url .= '&counterfilter=' . $data['counterfilter'];
        }

        if (isset($data['metalfilter'])) {
            $url .= '&metalfilter=' . $data['metalfilter'];
        }

        if (isset($data['payment_id'])) {
            $url .= '&payment_id=' . $data['payment_id'];
        }

        if (isset($data['oldsort']) && in_array(strtolower($data['oldsort']), ['tstamp', 'batch_num', 'metal_name', 'counteraccount_id', 'amount '])) {
            $url .= '&oldsort=' . $data['oldsort'];
        }

        if (isset($data['paymentsmade']) && $data['paymentsmade'] == true) {
            $url .= '&paymentsmade=1';
        }

        if (isset($data['paymentsmade']) && $data['paymentsmade'] == true) {
            $url .= '&paymentsmade=1';
        }

        if (isset($data['paymentsreceived']) && $data['paymentsreceived'] == true) {
            $url .= '&paymentsreceived=1';
        }

        // Get data from the server
        $url = file_get_contents($url, false, stream_context_create($this->ssl_fix));
        if (!$url) {
            return ['status' => 'error', 'message' => 'Connection error'];
        }

        if (substr($url, 0, 63) == 'Time,Type,Batch,Currency,Amount,Fee,Payer Account,Payee Account') {
            $lines = explode("\n", $url);

            // Getting table names (Time,Type,Batch,Currency,Amount,Fee,Payer Account,Payee Account)
            $rows = explode(",", $lines[0]);

            $return_data = [];

            // Fetching history
            $return_data['history'] = [];
            $iMax = count($lines);
            for ($i = 1; $i < $iMax; $i++) {

                // Skip empty lines
                if (empty($lines[$i])) {
                    break;
                }

                // Split line into items
                $items = explode(',', $lines[$i]);

                // Get history items
                $history_line = [];
                foreach ($items as $key => $value) {
                    $history_line[str_replace(' ', '_', strtolower($rows[$key]))] = $value;
                }

                $return_data['history'][] = $history_line;
            }

            $return_data['status'] = 'success';

            return $return_data;
        } else {
            return ['status' => 'error', 'message' => $url];
        }
    }

    public function generateHash(Request $request)
    {
        $string = '';
        $string .= $request->input('PAYMENT_ID') . ':';
        $string .= $request->input('PAYEE_ACCOUNT') . ':';
        $string .= $request->input('PAYMENT_AMOUNT') . ':';
        $string .= $request->input('PAYMENT_UNITS') . ':';
        $string .= $request->input('PAYMENT_BATCH_NUM') . ':';
        $string .= $request->input('PAYER_ACCOUNT') . ':';
        $string .= strtoupper(md5($this->alt_passphrase)) . ':';
        $string .= $request->input('TIMESTAMPGMT');
        return strtoupper(md5($string));
    }
}