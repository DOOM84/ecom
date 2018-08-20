<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use File;

class AdminProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(3);

        return view('admin.displayProducts', ['products' => $products]);
    }

    public function editProductForm($id)
    {
        $product = Product::find($id);
        return view('admin.editProductForm', compact('product'));
    }

    public function editProductImageForm($id)
    {
        $product = Product::find($id);
        return view('admin.editProductImageForm', compact('product'));

    }

    public function updateProductImage(Request $request, $id)
    {

        Validator::make($request->all(),['image' => 'required|file|image|mimes:jpg,png,jpeg|max:5000'])->validate();
        if ($request->hasFile('image')){
            $product = Product::find($id);
            $exists = Storage::disk('local')->exists('public/product_images/'.$product->image);
            if ($exists){
                Storage::delete('public/product_images/'.$product->image);
            }

            $ext = $request->file('image')->getClientOriginalExtension();

            $name = str_random(10).'.'.$ext;

            $request->image->storeAs('public/product_images/', $name);

            $product->image = $name;
            $product->save();

            return redirect()->route('adminDisplayProducts');

        }else{

           $error =  "No image was selected";
           return $error;

        }
        
    }

    public function updateProduct(Request $request, $id)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $type =$request->input('type');
        $price = substr($request->input('price'),1);

        $updateArray = [
           'name' =>  $name,
           'description' =>  $description,
           'type' =>  $type,
           'price' =>  $price,
        ];

        DB::table('products')->where('id', $id)->update($updateArray);

        return redirect()->route('adminDisplayProducts');
        
    }

    public function createProductForm()
    {
        return view('admin.createProductForm');
    }

    public function sendCreateProductForm(Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $type =$request->input('type');
        $price = $request->input('price');

        Validator::make($request->all(),['image' => 'required|file|image|mimes:jpg,png,jpeg|max:5000'])->validate();
        $ext = $request->file('image')->getClientOriginalExtension();
        $imgName = str_random(10).'.'.$ext;
        $imageEncoded = File::get($request->image);
        Storage::disk('local')->put('public/product_images/'.$imgName, $imageEncoded);

        $newProductArray = [
            'name' =>  $name,
            'description' =>  $description,
            'type' =>  $type,
            'price' =>  $price,
            'image' => $imgName
        ];

        $created = DB::table('products')->insert($newProductArray);

        if ($created){
            return redirect()->route('adminDisplayProducts');
        }else{
            return "Product was not created";
        }

    }

    public function deleteProduct($id)
    {
       $product = Product::find($id);

        $exists = Storage::disk('local')->exists('public/product_images/'.$product->image);
        if ($exists){
            Storage::delete('public/product_images/'.$product->image);
        }
       Product::destroy($id);
        return redirect()->route('adminDisplayProducts');
    }
}
