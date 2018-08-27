<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    //
    public function index(Request $request)
    {
        $products = Product::where(['on_sale' => true])->paginate();
        return view('products.index', ['products' => $products]);
    }
    
    
}
