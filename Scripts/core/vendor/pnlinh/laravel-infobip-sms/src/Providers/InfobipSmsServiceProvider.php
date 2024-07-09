<?php

namespace Pnlinh\InfobipSms\Providers;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Pnlinh\InfobipSms\Facades\InfobipSms;
use Pnlinh\InfobipSms\InfobipSmsService;

class InfobipSmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/infobip-sms.php' => config_path('infobip-sms.php'),
            ], 'infobip-sms');
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('infobip.sms', function (Container $app) {
            return new InfobipSmsService(
                $app['config']['infobip-sms.from'],
                $app['config']['infobip-sms.username'],
                $app['config']['infobip-sms.password']
            );
        });

        $this->app->alias('InfobipSms', InfobipSms::class);
    }
}
