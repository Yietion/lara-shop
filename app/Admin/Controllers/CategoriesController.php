<?php

namespace App\Admin\Controllers;

use App\models\Category;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class CategoriesController extends Controller
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
            ->header('商品类目列表')
            ->description('商品类目列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑商品类目')
            ->description('编辑商品类目')
            ->body($this->form(true)->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('创建商品类目')
            ->description('创建商品类目')
            ->body($this->form(false));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category);

        $grid->id('Id')->sortable();
        $grid->name('名称');
        $grid->parent_id('层级');
        $grid->is_directory('是否目录')->display(function($value){
        	return $value ? '是' : '否';
        });
        $grid->path('类目路径');
        $grid->actions(function ($actions) {
        	// 不展示 Laravel-Admin 默认的查看按钮
        	$actions->disableView();
        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($isEditing = false)
    {
        $form = new Form(new Category);

        $form->text('name', '类目名称')->rules('required');
        
        if($isEditing){
        	$form->display('is_directory', '是否目录')->with(function ($value) {
        		return $value ? '是' :'否';
        	});
        	// 支持用符号 . 来展示关联关系的字段
        	$form->display('parent.name', '父类目');
        }else {
        	$form->radio('is_directory', '是否目录')
        		->options(['1' => '是', '0' => '否'])
        		->default('0')
        		->rules('required');
        	$form->select('parent_id', '父类目')->ajax('/admin/api/categories');
        }

        return $form;
    }
    
    public function apiIndex(Request $request)
    {
    	// 用户输入的值通过 q 参数获取
    	$search = $request->input('q');
    	$result = Category::query()
    	->where('is_directory', boolval($request->input('is_directory', true)))  // 由于这里选择的是父类目，因此需要限定 is_directory 为 true
    	->where('name', 'like', '%'.$search.'%')
    	->paginate();
    
    	// 把查询出来的结果重新组装成 Laravel-Admin 需要的格式
    	$result->setCollection($result->getCollection()->map(function (Category $category) {
    		return ['id' => $category->id, 'text' => $category->full_name];
    	}));
    
    		return $result;
    }
}
