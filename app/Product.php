<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
