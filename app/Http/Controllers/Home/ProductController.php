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
        $category = Category::find($product->category->id);
        $products_category = $category->products()->get();
        $approvedComments = $product->approvedComment();
        return view('home.product.product_detailes', compact('product','products_category','approvedComments'));
    }
}
