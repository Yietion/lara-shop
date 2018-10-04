<?php 
namespace App\Admin\Controllers;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Layout\Content;
use App\Models\Product;
use Encore\Admin\Grid;
use Encore\Admin\Form;
use App\Models\Category;

abstract class CommonProductsController extends Controller
{
	use HasResourceActions;
	
	abstract public function getProductType();
	
	public function index(Content $content)
	{
		return $content->header(Product::$typemap[$this->getProductType()]. '列表')
		->body($this->grid());
	}
	
	public function edit($id, Content $content)
	{
		return $content
		->header('编辑'.Product::$typemap[$this->getProductType()])
		->body($this->form()->edit($id));
	}
	
	public function create(Content $content)
	{
		return $content
		->header('创建'.Product::$typemap[$this->getProductType()])
		->body($this->form());
	}
	
	protected function grid()
	{
		$grid = new Grid(new Product());
	
		// 筛选出当前类型的商品，默认 ID 倒序排序
		$grid->model()->where('type', $this->getProductType())->orderBy('id', 'desc');
		// 调用自定义方法
		$this->customGrid($grid);
	
		$grid->actions(function ($actions) {
			$actions->disableView();
			$actions->disableDelete();
		});
		$grid->tools(function ($tools) {
			$tools->batch(function ($batch) {
				$batch->disableDelete();
			});
		});
	
			return $grid;
	}
	abstract protected function customGrid(Grid $grid);
	
	protected function form()
	{
		$form = new Form(new Product());
		// 在表单页面中添加一个名为 type 的隐藏字段，值为当前商品类型
		$form->hidden('type')->value($this->getProductType());
		$form->text('title', '商品名称')->rules('required');
		$form->select('category_id', '类目')->options(function ($id) {
			$category = Category::find($id);
			if ($category) {
				return [$category->id => $category->full_name];
			}
		})->ajax('/admin/api/categories?is_directory=0');
		$form->image('image', '封面图片')->rules('required|image');
		$form->editor('description', '商品描述')->rules('required');
		$form->radio('on_sale', '上架')->options(['1' => '是', '0' => '否'])->default('0');
	
		// 调用自定义方法
		$this->customForm($form);
	
		$form->hasMany('skus', '商品 SKU', function (Form\NestedForm $form) {
			$form->text('title', 'SKU 名称')->rules('required');
			$form->text('description', 'SKU 描述')->rules('required');
			$form->text('price', '单价')->rules('required|numeric|min:0.01');
			$form->text('stock', '剩余库存')->rules('required|integer|min:0');
		});
		$form->saving(function (Form $form) {
			$form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;
		});
	
			return $form;
	}
	
	// 定义一个抽象方法，各个类型的控制器将实现本方法来定义表单应该有哪些额外的字段
	abstract protected function customForm(Form $form);
}