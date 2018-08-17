<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('products', ['uses' => 'ProductsController@index', 'as' => 'allProducts']);

Route::get('product/addToCart/{id}', ['uses' => 'ProductsController@addProductToCart', 'as' => 'AddToCartProduct']);

Route::get('cart', ['uses' => 'ProductsController@showCart', 'as' => 'cartproducts']);

Route::get('product/deleteItemFromCart/{id}', ['uses' => 'ProductsController@deleteItemFromCart', 'as' => 'DeleteItemFromCart']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('admin/products', ['uses' => 'Admin\AdminProductsController@index', 'as' => 'adminDisplayProducts']);

Route::get('admin/editProductForm/{id}', ['uses' => 'Admin\AdminProductsController@editProductForm', 'as' => 'adminEditProductForm']);

Route::get('admin/editProductImageForm/{id}', ['uses' => 'Admin\AdminProductsController@editProductImageForm', 'as' => 'adminEditProductImageForm']);

Route::post('admin/updateProductImage/{id}', ['uses' => 'Admin\AdminProductsController@updateProductImage', 'as' => 'adminUpdateProductImage']);

Route::post('admin/updateProduct/{id}', ['uses' => 'Admin\AdminProductsController@updateProduct', 'as' => 'adminUpdateProduct']);

Route::get('admin/createProductForm', ['uses' => 'Admin\AdminProductsController@createProductForm', 'as' => 'adminCreateProductForm']);

Route::post('admin/sendCreateProductForm/', ['uses' => 'Admin\AdminProductsController@sendCreateProductForm', 'as' => 'adminSendCreateProductForm']);