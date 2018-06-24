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

use App\Product;
use App\Transaction;

Route::get('/', function () {
    return view('welcome');
});
//
//Route::get('/transactions/{id}/categories',function ($id){
//        $transaction= Transaction::find($id);
//        $products= Product::where('id',$transaction->product_id)->get();
//        foreach ($products as $product){
//            echo dd($product->categories);
//        }
//});