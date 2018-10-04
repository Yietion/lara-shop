<?php 
namespace App\Http\ViewComposers;
use App\Services\CategoryService;
use Illuminate\View\View;
class CategoryTreeComposer
{
	protected $categoryServierce;
	
	public function __construct(CategoryService $categoryService)
	{
		$this->categoryServierce = $categoryService;
	}
	
	public function compose(View $view)
	{
		$view->with('categoryTree', $this->categoryServierce->getCategoryTree());
	}
}