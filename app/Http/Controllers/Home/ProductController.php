<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product_category = Category::find($product->category->id);
        return view('home.product.product_detailes', compact('product','product_category'));
    }
}
