<?php

namespace App\Listeners;

use DB;

use App\Events\OrderReviewd;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\OrderItem;

class UpdateProductRating
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
     * @param  OrderReviewd  $event
     * @return void
     */
    public function handle(OrderReviewd $event)
    {
        //
        $items = $event->getOrder()->items()->with(['product'])->get();
        foreach ($items as $item){
        	$result = OrderItem::query()
        	->where('product_id', $item->product_id)
        	->whereHas('order', function ($query){
        		$query->whereNotNull('paid_at');
        	})
        	->first([
        			DB::raw('count(* ) as review_count'),
        			DB::raw('avg(rating) as rating')
        	]);
        	$item->product->update([
        		'rating'       => $result->rating,
                'review_count' => $result->review_count,
        	]);
        }
    }
}
