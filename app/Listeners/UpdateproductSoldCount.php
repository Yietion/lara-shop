<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\OrderItem;

class UpdateproductSoldCount implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderPaid  $event
     * @return void
     */
    public function handle(OrderPaid $event)
    {
        //
        $order = $event->getOrder();
        foreach ($order->items as $item){
        	$product = $item->product;
        	$soldCount = OrderItem::query()
        	->where('product_id', $product->id)
        	->whereHas('order', function ($query){
        		$query->whereNotNull('paid_at');
        	})->sum('amount');
        	$product->update([
        			'sold_count'=>$soldCount
        	]);
        }
    }
}
