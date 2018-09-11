<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Order;

class CloseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, $delay)
    {
        //
        $this->order = $order;
        // 设置延迟的时间，delay() 方法的参数代表多少秒之后执行
        $this->delay($delay);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if($this->order->paid_at){
        	return ;
        }
        \DB::transaction(function(){
        	$this->order->update(['closed' => true]);
        	// 循环遍历订单中的商品 SKU，将订单中的数量加回到 SKU 的库存中去
        	foreach ($this->order->items as $item) {
        		$item->productSku->addStock($item->amount);
        	}
        	if ($this->order->couponCode) {
        		$this->order->couponCode->changeUsed(false);
        	}
        });
    }
    
}
