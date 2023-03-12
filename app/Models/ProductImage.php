<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function product()
    {
        return $this->hasOne('App\Models\Product','product_id');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image','category_id');
    }
}
