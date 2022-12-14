<?php

namespace App\Http\Controllers;

use App\Basket;
use App\BasketProduct;
use App\Category;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        } else {
            $categoryMenu = Category::orderBy('category_name', 'asc')->get();
            $categories = Category::orderBy('category_name', 'asc')->get();
            if (Cart::content()->count() > 0) {
                // Set your Merchant Server Key
                \Midtrans\Config::$serverKey = 'SB-Mid-server-GhmpccQBulvWT9eMiO3MZtqy';
                // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                \Midtrans\Config::$isProduction = false;
                // Set sanitization on (default)
                \Midtrans\Config::$isSanitized = true;
                // Set 3DS transaction for credit card to true
                \Midtrans\Config::$is3ds = true;

                $params = array(
                    'transaction_details' => array(
                        'order_id' => rand(),
                        'gross_amount' => Cart::total(),
                    ),
                    'customer_details' => array(
                        'first_name' => Auth::user()->name,
                        'last_name' => Auth::user()->surname,
                        'email' => Auth::user()->email,
                        'phone' => Auth::user()->detail->phone,
                    ),
                );

                $snapToken = \Midtrans\Snap::getSnapToken($params);
            } else {
                $snapToken = '';
            }
            return view('basket', compact('categories', 'categoryMenu', 'snapToken'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::check()) {
            abort(400);
        } else {
            $quantity = request('quantity');
            if ($quantity < 1) {
                abort(400);
            }
            $product = Product::find(request('id'));
            $cartItem = Cart::add($product->id, $product->product_name, $quantity, $product->product_price, ['slug' => $product->slug]);

            if (Auth::check()) {
                $active_basket_id = session('active_basket_id');
                if (!isset($active_basket_id)) {
                    $active_basket = Basket::create([
                        'user_id' => Auth::id()
                    ]);
                    $active_basket_id = $active_basket->id;
                    session()->put('active_basket_id', $active_basket_id);
                }

                BasketProduct::updateOrCreate(
                    ['basket_id' => $active_basket_id, 'product_id' => $product->id],
                    ['quantity' => $cartItem->qty, 'price' => $product->product_price, 'status' => 'Your orders have received.']
                );
            }
        }
        return response()->json(['cartCount' => Cart::count()]);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($rowid)
    {
        //
        if (Auth::check()) {
            $active_basket_id = session('active_basket_id');
            $cartItem = Cart::get($rowid);

            if (request('quantity') == 0)
                BasketProduct::where('basket_id', $active_basket_id)->where('product_id', $cartItem->id)
                    ->delete();
            else
                BasketProduct::where('basket_id', $active_basket_id)->where('product_id', $cartItem->id)
                    ->update(['quantity' => request('quantity')]);
        }

        Cart::update($rowid, request('quantity'));


        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        if (Auth::check()) {
            $active_basket_id = session('active_basket_id');
            BasketProduct::where('basket_id', $active_basket_id)->delete();
        }

        Cart::destroy();

        return redirect()->route('basket');
    }
}