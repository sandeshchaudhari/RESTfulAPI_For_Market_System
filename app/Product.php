<?php

namespace App;

use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;

class Product extends Model
{
    use SoftDeletes;
    protected $dates=['deleted_at'];
    public $transformer=ProductTransformer::class;
    protected $hidden=['pivot'];
    const AVAILABLE_PRODUCT='available';
    const UNAVAILABLE_PRODUCT='unavailable';
    protected $fillable=[
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];
    public function isAvailable(){
        return $this->status==Product::AVAILABLE_PRODUCT;
    }

    //Many To Many Relationship
    public function categories(){
        return $this->belongsToMany('App\Category');
    }

    //One To One Relationship
    public function seller(){
        return $this->belongsTo('App\Seller');
    }

    //One To Many Relationship
    public function transactions(){
        return $this->hasMany('App\Transaction');
    }
}
