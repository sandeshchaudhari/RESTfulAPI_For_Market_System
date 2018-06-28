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
 * User Routes
 */
Route::resource('/users','User\UserController',['except'=>['create','edit']]);

Route::name('verify')->get('users/verify/{token}','User\UserController@verify');

Route::name('resend')->get('users/{user}/resend','User\UserController@resend');

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
Route::resource('/products.transactions','Product\ProductTransactionController',['only'=>['index']]);
Route::resource('/products.categories','Product\ProductCategoryController');
Route::resource('/products.sellers','Product\ProductSellerController');
Route::resource('/products.buyers','Product\ProductBuyerController');
Route::resource('/products.buyers.transactions','Product\ProductBuyerTransactionController',['only'=>['store']]);
/*
 * Seller Routes
 */
Route::resource('/sellers','Seller\SellerController',['only'=>['index','show']]);
Route::resource('/sellers.transactions','Seller\SellerTransactionController',['only'=>['index']]);
Route::resource('/sellers.products','Seller\SellerProductController');
Route::resource('/sellers.categories','Seller\SellerCategoryController',['only'=>['index']]);
Route::resource('/sellers.buyers','Seller\SellerBuyerController',['only'=>['index']]);
/*
 * Transaction Routes
 */
Route::resource('/transactions','Transaction\TransactionController',['only'=>['index','show']]);

/*
 * TransactionCategory Routes
 */
Route::resource('/transactions.categories','Transaction\TransactionCategoryController');

Route::resource('/transactions.sellers','Transaction\TransactionSellerController');

/*
 * Buyer Specific Transaction Routes
 */
Route::resource('/buyer.transactions','Buyer\BuyerTransactionController');

/*
 * Buyer Specific Products Routes
 */
Route::resource('/buyer.products','Buyer\BuyerProductController');

/*
 * Buyer Seller Specific Routes
 */
Route::resource('/buyer.seller','Buyer\BuyerSellerController');

/*
 * Buyer Seller Specific Routes
 */
Route::resource('/buyer.categories','Buyer\BuyerCategoryController');

/*
 * Buyer Seller Specific Routes
 */
Route::resource('/categories.products','Category\CategoryProductController');

/*
 * Category Seller Specific Routes
 */
Route::resource('/categories.sellers','Category\CategorySellerController');

/*
 * Category Buyer Specific Routes
 */
Route::resource('/categories.buyers','Category\CategoryBuyerController');

/*
 * Category Transaction Specific Routes
 */
Route::resource('/categories.transactions','Category\CategoryTransactionController');



