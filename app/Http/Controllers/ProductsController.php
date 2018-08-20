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
        $products = Product::paginate(3);

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

       return redirect()->route('allProducts');

    }

    public function deleteItemFromCart(Request $request, $id)
    {
        $cart = $request->session()->get('cart');

      if (array_key_exists($id, $cart->items)){
          unset($cart->items[$id]);
      }

      $prevCart = $request->session()->get('cart');

      $updatedCart = new Cart($prevCart);

      $updatedCart->updatePriceAndQuantity();

        $request->session()->put('cart', $updatedCart);

        return redirect()->route('cartproducts');

    }

    public function menProducts()
    {

        $products = Product::where('type', 'Men')->get();
        return view('menProducts', compact('products'));

    }

    public function womenProducts ()
    {
        $products = Product::where('type', 'Women')->get();
        return view('womenProducts', compact('products'));
    }

    public function search(Request $request)
    {
        $searchText = $request->get('searchText');
        $products = Product::where('name', 'LIKE', $searchText.'%')->paginate(3);
        return view('allproducts', compact('products'));
    }
}
