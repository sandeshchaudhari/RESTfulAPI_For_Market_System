<?php
/**
 * Created by PhpStorm.
 * User: sandesh
 * Date: 23-Jun-18
 * Time: 05:44 PM
 */

namespace App\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SellerScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // TODO: Implement apply() method.
        $builder->has('products');
    }

}