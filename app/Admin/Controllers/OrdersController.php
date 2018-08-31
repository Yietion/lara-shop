<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

use App\Exceptions\InvalidRequestException;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('订单列表')
            ->description('订单列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show(Order $order, Content $content)
    {
        return $content
            ->header('查看订单')
            ->description('查看订单')
            ->body(view('admin.orders.show', ['order'=>$order]));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);
		$grid->model()->whereNotNull('paid_at')->orderBy('paid_at', 'desc');

        $grid->no('订单流水号');
        $grid->column('user.name', '买家');
        $grid->total_amount('总金额')->sortable();
        $grid->paid_at('支付时间')->sortable();
        $grid->ship_status('物流')->display(function($value){
        	return Order::$shipStatusMap[$value];
        });
        $grid->refund_status('退款状态')->display(function ($value){
        	return Order::$refundStatusMap[$value];
        });
        $grid->disableCreateButton();
        $grid->actions(function ($actions){
        	$actions->disableDelete();
        	$actions->disableEdit();
        });
        
        $grid->tools(function ($tools){
        	$tools->batch(function($batch){
        		$batch->disableDelete();
        	});
        });
        return $grid;
    }
	
    public function ship(Order $order, Request $request)
    {
    	if(!$order->paid_at){
    		throw new InvalidRequestException('该订单未付款');
    	}
    	if($order->ship_status !== Order::SHIP_STATUS_PENDING){
    		throw new InvalidRequestException('该订单已发货');
    	}
    	$data = $this->validate($request, [
    		'express_company' => ['required'],
            'express_no'      => ['required'],
    	],[],[
    			'express_company' => '物流公司',
    			'express_no'      => '物流单号',
    	]);
    	$order->update([
    		'ship_status' => Order::SHIP_STATUS_DELIVERED,
    		'ship_data'   => $data,
    	]);
    	return redirect()->back();
    }
}
