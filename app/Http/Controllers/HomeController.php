<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Order;
use App\BasketProduct;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        $products = BasketProduct::productSold()->get();
        $img = Product::get()->toArray();
        // $products = BasketProduct::rightJoin('products', 'products.id', '=', 'product_id')
        //     ->selectRaw('*, IFNULL(SUM(quantity),0) as qty')->orderBy('product_id', 'asc')->groupBy('products.id')
        //     ->get();
        // $imgs = array_merge($products, $img);
        // dd($img);

        return view('index', compact('products', 'categoryMenu', 'img'));
    }

    public function category($slug)
    {
        $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        $category = Category::where("slug", $slug)->first();
        $products = Product::with('categories')->where('category_id', $category->id)->get();
        return view('category-details', compact('category', 'products', 'categoryMenu'));
    }

    public function product($slug)
    {
        $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        $product = Product::where("slug", $slug)->first();
        $bcrumb = $product->categories()->distinct()->get();
        // dd($bcrumb);
        return view('product-detail', compact('product', 'bcrumb', 'categoryMenu'));
    }

    public function contact()
    {
        $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        return view('contact', compact('categoryMenu'));
    }
}