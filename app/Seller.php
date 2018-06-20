<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends User
{
    //One To Many Relationship
    public function products(){
        return $this->hasMany('App\Product');
    }
}
