<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;


class ProductController extends Controller
{
    public function getProduct($category, $product_id){
        $product = Product::where('id', $product_id)->first();

        return view('product.show', [
            'product' => $product
        ]);
    }

    public function showCategory(Request $request, $category_alias){
        $category = Category::where('alias', $category_alias)->first();
        $paginate = 1;
        $products = Product::where('category_id', $category->id)->paginate($paginate);

        if(isset($request->orderBy)){
            if($request->orderBy == 'price-low-high'){
                $products = Product::where('category_id', $category->id)->orderBy('price')->paginate($paginate);
            }
            if($request->orderBy == 'price-high-low'){
                $products = Product::where('category_id', $category->id)->orderBy('price', 'desc')->paginate($paginate);
            }
            if($request->orderBy == 'name-a-z'){
                $products = Product::where('category_id', $category->id)->orderBy('title')->paginate($paginate);
            }
            if($request->orderBy == 'name-z-a'){
                $products = Product::where('category_id', $category->id)->orderBy('title', 'desc')->paginate($paginate);
            }
        }

        if($request->ajax()){
            return view('ajax.order-by', [
              'products' => $products    
            ])->render();
        }
        
        return view('categories.index', [
            'category' => $category,
            'products' => $products
        ]);
    }
}
