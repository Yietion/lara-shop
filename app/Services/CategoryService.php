<?php 
namespace App\Services;

use App\Models\Category;
class CategoryService
{
	public function getCategoryTree($parentId = NULL, $allCategories = NULL)
	{
		if(is_null($allCategories)){
			$allCategorire = Category::all();
		}
		return $allCategorire->where('parent_id', $parentId)
		->map(function (Category $category) use ($allCategories){
			$data = ['id' => $category->id, 'name' => $category->name];
			if(!$category->is_directory){
				return $data;
			}
			$data['children'] = $this->getCategoryTree($category->id, $allCategories);
			return $data;
		});
	}
}