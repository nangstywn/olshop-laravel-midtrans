<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasketProduct extends Model
{
    //
    protected $table = "basket_products";
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }

    public function scopeProductSold()
    {
        return $this->rightJoin('products', 'products.id', '=', 'product_id')
            ->selectRaw('*, IFNULL(SUM(quantity),0) as qty')->groupBy('products.id');
    }
}