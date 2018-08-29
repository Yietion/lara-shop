<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Models\UserAddress;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\ProductSku;

class OrdersController extends Controller
{
    //
    public function store(OrderRequest $request)
    {
    	$user = $request->user();
    	$order = \DB::transaction(function ()use ($request, $user){
    		$address = UserAddress::find($request->input('address_id'));
    		$address->update(['last_used_at'=>Carbon::now()]);
    		$order = new Order([
    				'address' => [
    					'address'=>$address->full_address,
    					'zip' => $address->zip,
    					'contact_name'  => $address->contact_name,
    					'contact_phone' => $address->contact_phone,
    				],
    				'remark' => $request->input(''),
    				'total_amount' => 0,
    		]);
    		$order->user()->associate($user);
    		$order->save();
    		$totalAmount  = 0;
    		$items = $request->input('items');
    		foreach ($items as $data){
    			$sku = ProductSku::find($data['sku_id']);
    			$item = $order->items()->make([
    					'amount' => $data['amount'],
    					'price' => $sku->price,
    			]);
    			$item->product()->associate($sku->product_id);
    			$item->productSku()->associate($sku);
    			$item->save();
    			$totalAmount  += $sku->price * $data['amount'];
    		}
    		$order->update(['total_amount' => $totalAmount]);
    		$skuIds = collect($request->input('items'))->pluck('sku_id');
    		$user->cartItems()->whereIn('product_sku_id', $skuIds)->delete();
    		return $order;
    	});
    		return $order;
    }
}
 