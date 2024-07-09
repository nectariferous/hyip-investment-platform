<?php

use Pnlinh\InfobipSms\Facades\InfobipSms;

if (!function_exists('infobip_sms_send')) {
    /**
     * @param $to
     * @param $text
     *
     * @return mixed
     */
    function infobip_sms_send($to, $text)
    {
        return InfobipSms::send($to, $text);
    }
}
