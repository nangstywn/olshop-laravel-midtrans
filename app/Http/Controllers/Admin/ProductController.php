<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Images;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        $products = Product::orderBy('id', 'desc')->paginate(5);
        // dd($products);
        return view('admin.products', compact('products', 'categoryMenu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        $categoriess = Category::pluck("category_name", "id")->all();
        $products = Product::pluck("product_name", "id")->all();
        return view("admin.products-create", compact('products', 'categoriess', 'categoryMenu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate(
            $request,
            [
                "category_id" => "required",
                "product_name" => "required",
                "product_detail" => "required",
                "original_price" => "required|numeric",
                "product_price" => "required|numeric",
                "img" => "required"
            ]
        );


        $input = $request->only('category_id', 'product_name', 'product_detail', 'original_price', 'product_price');

        $product = Product::create($input);


        $imgs = array();

        if ($files = $request->file("img")) {
            foreach ($files as $key => $file) {
                $rand = rand(1, 999999) . $key . $product;
                $image_name = $rand . "." . $file->getClientOriginalExtension();
                $thumb = "thumb_" . $rand . "." . $file->getClientOriginalExtension();

                Image::make($file->getRealPath())->resize(454, 527)->save(public_path("uploads/" . $image_name));
                Image::make($file->getRealPath())->resize(235, 235)->save(public_path("uploads/" . $thumb));

                $input = [];
                $input["name"] = $image_name;
                $input["imageable_id"] = $product->id;
                $input["imageable_type"] = "App\Product";


                $imgs[] = $image_name;
                Images::create($input);
            }
        }
        Session::flash("status", 1);
        return redirect()->route('admin-products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        $categoriess = Category::pluck("category_name", "id")->all();
        $products = Product::find($id);
        return view("admin.products-edit", compact('categoriess', 'products', 'categoryMenu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                "product_detail" => "required",
                "original_price" => "required|numeric",
                "product_price" => "required|numeric"
            ]
        );
        $input = $request->only('category_id', 'product_name', 'product_detail', 'original_price', 'product_price');
        $products = Product::find($id);
        $products->update($input);


        $imgs = array();
        if ($files = $request->file("img")) {
            // foreach ($product->images as $product) {
            $n = count($files);
            for ($i = 0; $i < $n; $i++) {
                // dd($product->images[$i]);
                $rand = rand(1, 999999) . $products->id;
                $image_name = isset($products->images[$i]) ? $products->images[$i]->name : $rand . "." . $files[$i]->getClientOriginalExtension();
                $thumb = isset($products->images[$i]) ? "thumb_" . $products->images[$i]->name : "thumb_" . $rand . "." . $files[$i]->getClientOriginalExtension();
                // $file = $files[$i];
                // foreach ($files as $file) {
                Image::make($files[$i]->getRealPath())->resize(454, 527)->save(public_path("uploads/" . $image_name));
                Image::make($files[$i]->getRealPath())->resize(235, 235)->save(public_path("uploads/" . $thumb));
                $imgs[] = $image_name;
            }
            $foto = [];
            foreach ($products->images as $product) {
                $foto[] = $product->name;
            }
            $ims = [];
            foreach ($imgs as $im) {
                if (!in_array($im, $foto)) {
                    $input = [];
                    $input["name"] = $im;
                    $input["imageable_id"] = $products->id;
                    $input["imageable_type"] = "App\Product";
                    $imgs[] = $im;
                    Images::create($input);
                }
            }
            // dd($ims);
            foreach ($foto as $fotos) {
                if (!in_array($fotos, $imgs)) {
                    $img = $fotos;
                    @unlink(public_path("uploads/" . $img));
                    @unlink(public_path("uploads/thumb_" . $img));
                    Images::where("imageable_id", $products->id)->where('name', $img)->where("imageable_type", "App\Product")->delete();
                }
            }

            //     if (in_array($product->name, $imgs)) {
            //         $foto[] = $imgs;
            //     } else {
            //         $input = [];
            //         $input["name"] = $image_name;
            //         $input["imageable_id"] = $product->id;
            //         $input["imageable_type"] = "App\Product";


            //         $imgs[] = $image_name;
            //         Images::create($input);
            //     }
            // }
            // dd($foto);
        }



        // if ($files = $request->file("img")) {
        //     foreach ($products->images as $product) {
        //         $image_name = $product->name;
        //         $thumb = "thumb_" . $product->name;
        //         foreach ($files as $file) {
        //             Image::make($file->getRealPath())->resize(454, 527)->save(public_path("uploads/" . $image_name));
        //             Image::make($file->getRealPath())->resize(235, 235)->save(public_path("uploads/" . $thumb));
        //         }
        //         $imgs[] = $image_name;
        //     }
        // }

        Session::flash("status", 1);
        return redirect()->route('admin-products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $img = Images::where('imageable_id', $id)->get();
        foreach ($img as $im) {
            @unlink(public_path("uploads/" . $im->name));
            @unlink(public_path("uploads/thumb_" . $im->name));
        }

        Images::where("imageable_id", $id)->where("imageable_type", "App\Product")->delete();

        Product::destroy($id);

        Session::flash("status", 1);

        return redirect()->route('admin-products.index');
    }
}