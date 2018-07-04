<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Traits\ApiResponser;
use App\Transaction;
use App\Transformers\TransactionTransformer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class ProductBuyerTransactionController extends ApiController
{
    use ApiResponser;
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:' . TransactionTransformer::class)->only(['store']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Product $product,User $buyer)
    {
        $rules=[
            'quantity'=>'required|integer|min:1',
        ];
        $this->validate($request,$rules);
        if($buyer->id==$product->seller_id){
            return $this->errorResponse('The buyer must be different from the seller',408);
        }
        if(!$buyer->isVerified()){
            return $this->errorResponse('The buyer must be verified user',409);
        }
        if(!$product->seller->isVerified()){
            return $this->errorResponse('The seller must be verified user',409);
        }
        if(!$product->isAvailable()){
            return $this->errorResponse('The product is not available',409);
        }
        if($product->quantity<$request->quantity){
            return $this->errorResponse('The products does not have eough units for this transactions',409);
        }
        return DB::transaction(function ()use($request,$product,$buyer){
           $product->quantity=$product->quantity-$request->quantity;
           $product->save();
            $transaction=Transaction::create([
               'quantity'=>$request->quantity,
                'product_id'=>$product->id,
                'buyer_id'=>$buyer->id
            ]);
            return $this->showOne($transaction);

        });

    }


}
