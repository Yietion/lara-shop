<?php 
namespace App\Services;

use Auth;
use App\Models\CartItem;

class CartService
{
	public function get()
	{
		return Auth::user()->cartitems()->with(['productSku.product'])->get();
	}
	
	public function add($sku_id, $amount)
	{
		$user = Auth::user();
		if($item = $user->cartItems()->where('product_sku_id', $sku_id)->first()){
			$item->update([
					'amount' => $item->amount + $amount
			]);
		}else{
			$item = new CartItem(['amount'=>$amount]);
			$item->user()->associate($user);
			$item->productSku()->associate($sku_id);
			$item->save();
		}
		return $item;
	}
	
	public function remove($skuIds)
	{
		if(!is_array($skuIds)){
			$skuIds = [$skuIds];
		}
		Auth::user()->cartItems()->whereIn('product_sku_id', $skuIds)->delete();
	}
}
