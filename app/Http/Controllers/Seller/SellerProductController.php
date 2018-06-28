<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Seller;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products=$seller->products;
        return $this->showAll($products);
    }

    /**
     * Store product related to seller
     * @param Request $request
     * @param User $seller
     */
    public function store(Request $request, User $seller){
        $rules=[
            'name'=>'required',
            'description'=>'required',
            'quantity'=>'required|min:1',
            'image'=>'required|image',

        ];
        $this->validate($request,$rules);
        $data=$request->all();
        $data['status']=Product::UNAVAILABLE_PRODUCT;
        $data['image']='1.jpg';
        $data['seller_id']=$seller->id;
        $product=Product::create($data);
        return $this->showOne($product);

    }
    public function update(Request $request,Seller $seller,Product $product){
        $rules=[
            'quantity'=>'integer|min:1',
            'status'=>'in:'.Product::UNAVAILABLE_PRODUCT.','.Product::AVAILABLE_PRODUCT,
            'image'=>'required',
        ];
        $this->validate($request,$rules);
        $this->checkSeller($seller,$product);
        $product->fill($request->only(['name','description','quantity']));
        if($request->has('status')){
            $product->status=$request->status;
            if($product->isAvailable()&& $product->categories()->count()==0){
                return $this->errorResponse('An active product must have atleast one category',409);
            }
        }
         if($product->isClean()){
            return $this->errorResponse('You need to specify different value in order to update',422);
         }
         $product->save();
         return $this->showOne($product);

    }
    public function destroy(Seller $seller,Product $product){
        $this->checkSeller($seller,$product);
        $product->delete();
        return $this->showOne($product);
    }

    public function checkSeller(Seller $seller,Product $product)
    {
        if($seller->id!=$product->seller_id){
            throw new HttpException(422,'The specified seller is not the actual seller of the product');
        }
    }



}
