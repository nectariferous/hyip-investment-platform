<?php

namespace Pnlinh\InfobipSms\Facades;

use Illuminate\Support\Facades\Facade;

class InfobipSms extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'infobip.sms';
    }
}
