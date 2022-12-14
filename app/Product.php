<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = "products";

    protected $guarded = [];


    protected $appends = ["thumbs"];

    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'product_name'
            ]
        ];
    }


    public function categories()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    public function basketProduct()
    {
        return $this->hasMany('App\BasketProduct');
    }



    public function images()
    {
        return $this->morphMany("App\Images", "imageable");
    }

    public function getThumbsAttribute()
    {
        $img = isset($this->images->first()->name) ? $this->images->first()->name : $this->images->first();
        $images = asset("uploads/thumb_" . $img);
        // dd($images);
        return '<img src="' . $images . '" class="img-thumbnail" width="100" />';
    }
}