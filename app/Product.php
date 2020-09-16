<?php

namespace App;

use App\Category;
use App\Order;
use App\Review;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{


    protected $fillable = [
        'name', 'category_id', 'detail', 'stock','price','discount'
    ];

    function relationToCategory()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


	public function reviews()
    {
    	return $this->hasMany(Review::class);
    }
}
