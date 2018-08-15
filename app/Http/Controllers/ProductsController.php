<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('allproducts', compact('products'));
    }

    public function addProductToCart(Request $request, $id)
    {
        /*$request->session()->forget('cart');
        return true;*/

        $prevCart = $request->session()->get('cart');
        $cart = new Cart($prevCart);

        $product = Product::find($id);
        $cart->addItem($id,$product);
        $request->session()->put('cart',$cart);
        //dump($cart);
        return redirect()->route('allProducts');

    }

    public function showCart()
    {
       $cartItems = Session::get('cart');

       if($cartItems){
           return view('cartProducts', compact('cartItems'));
       }

       return redirect(route('allProducts'));

    }
}
