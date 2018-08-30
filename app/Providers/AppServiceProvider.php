<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Yansongda\Pay\Pay;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('alipay', function (){
        	$config = config('pay.alipay');
        	//$config['notify_url'] = route('payment.alipay.notify');
        	$config['return_url'] = route('payment.alipay.return');
        	$config['notify_url'] = 'http://requestbin.leo108.com/vg5kzqvg';
        	if(app()->environment() !== "production"){
        		$config['mode'] = "dev";
        		$config['log']['level'] = Logger::DEBUG;
        	}else {
        		$config['log']['level'] = Logger::WARNING;
        	}
        	return Pay::alipay($config);
        });
        
        $this->app->singleton('wechat_pay', function () {
        	$config = config('pay.wechat');
        	if (app()->environment() !== 'production') {
        		$config['log']['level'] = Logger::DEBUG;
        	} else {
        		$config['log']['level'] = Logger::WARNING;
        	}
        	// 调用 Yansongda\Pay 来创建一个微信支付对象
        	return Pay::wechat($config);
        });        	
    }
}
