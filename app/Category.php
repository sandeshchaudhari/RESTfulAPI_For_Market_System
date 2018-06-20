<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['name','description'];

    //Many To Many Relationship to Product
    public function products(){
        return $this->belongsToMany('App\Product');
    }
}
