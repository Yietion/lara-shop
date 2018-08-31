<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Exceptions\InvalidRequestException;
use Carbon\Carbon;
use Encore\Admin\Grid\Filter\Where;
use App\Events\OrderPaid;

class PaymentController extends Controller
{
    //
    public function payByAlipay(Order $order, Request $request)
    {
    	$this->authorize('own', $order);
    	if($order->paid_at || $order->closed){
    		throw new InvalidRequestException('订单状态不正确');
    	}
    	return app('alipay')->web([
    			'out_trade_no' => $order->no,
    			'total_amount'=> $order->total_amount,
    			'subject' => '支付 Lara Shop 的订单：'.$order->no,
    			]);
    }
    
    public function alipayReturn()
    {
    	try {
            app('alipay')->verify();
        } catch (\Exception $e) {
            return view('pages.error', ['msg' => '数据不正确']);
        }

        return view('pages.success', ['msg' => '付款成功']);
    }
    
    public function alipayNotify()
    {
    	$data = app('alipay')->verify();
    	\Log::debug('Alipay notify', $data->all());
    	$order = Order::where('no', $data->out_trade_no)->first();
    	if (!$order) {
    		return 'fail';
    	}
    	// 如果这笔订单的状态已经是已支付
    	if ($order->paid_at) {
    		// 返回数据给支付宝
    		return app('alipay')->success();
    	}
    	
    	$order->update([
    			'paid_at'        => Carbon::now(), // 支付时间
    			'payment_method' => 'alipay', // 支付方式
    			'payment_no'     => $data->trade_no, // 支付宝订单号
    	]);
    	
    	$this->afterPaid($order);
    	return app('alipay')->success();
    }
    
    public function payByWechat(Order $order, Request $request)
    {
    	$this->authorize('own', $order);
    	if($order->paid_at || $order->closed){
    		throw new InvalidRequestException('订单状态不正确');
    	}
    	return app('wechat_pay')->scan([
    			'out_trade_no' => $order->no,
    			'total_fee' => $order->total_amount*100,
    			'body' => '支付Lara Shop的订单：'.$order->no
    	]);
    	$qrCode = new QrCode($wechatOrder->code_url);
    	return response($qrCode->writeString(), 200, ['Content-Type' => $qrCode->getContentType()]);
    }
    
    public function wechatNotify()
    {
    	$data = app('wechat_pay')->verify();
    	
    	$order = Order::Where('no', $data->out_trade_no)->first();
    	if(!$order){
    		return 'fail';
    	}
    	if($order->paid_at){
    		return app('wechat_pay')->success();
    	}
    	$order->update([
    			'paid_at' => Carbon::now(),
    			'payment_method' => 'wechat',
    			'payment_no' => $data->transaction_id 
    	]);
    	$this->afterPaid($order);
    	return app('wechat_pay')->success();
    }
    
    protected  function afterPaid(Order $order)
    {
    	event(new OrderPaid($order));
    }
}
