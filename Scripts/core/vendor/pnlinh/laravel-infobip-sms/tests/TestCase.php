<?php

namespace Pnlinh\InfobipSms\Tests;

use Pnlinh\InfobipSms\Providers\InfobipSmsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function getPackageProviders($app)
    {
        return [
            InfobipSmsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('infobip-sms.from', 'foo');
        $app['config']->set('infobip-sms.username', 'bar');
        $app['config']->set('infobip-sms.password', '123');
    }
}
