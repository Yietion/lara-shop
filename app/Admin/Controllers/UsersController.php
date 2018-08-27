<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UsersController extends Controller
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
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->id('Id')->sortable();
        $grid->name('用户名');
        $grid->email('邮箱');
        $grid->email_verified('已邮箱验证')->display(function($value){
            return $value ? '是' : '否';
        });
        $grid->created_at('注册时间');
        $grid->disableCreateButton();
        $grid->actions(function($action){
            $action->disableView();
            $action->disableDelete();
            $action->disableEdit();
        });
        $grid->tools(function($tools){
            
            $tools->batch(function ($batch){
                $batch->disableDelete();
            });
        });
        return $grid;
    }
}
