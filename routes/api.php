<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * Buyer Routes
 */
Route::resource('/buyers','Buyer\BuyerController',['only'=>['index','show']]);
/*
 * Categories Routes
 */
Route::resource('/categories','Category\CategoryController',['except'=>['create','edit']]);
/*
 * Product Routes
 */
Route::resource('/products','Product\ProductController',['only'=>['index','show']]);
/*
 * Seller Routes
 */
Route::resource('/sellers','Seller\SellerController',['only'=>['index','show']]);
/*
 * Transaction Routes
 */
Route::resource('/transactions','Transaction\TransactionController',['only'=>['index','show']]);

/*
 * User Routes
 */
Route::resource('/users','User\UserController',['except'=>['create','edit']]);