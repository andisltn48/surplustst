<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getEnableAttribute($value)
    {
        if (in_array($value,[1,true])) {
            return true;
        }
        return false;
    }

    public function category_product()
    {
        return $this->hasOne('App\Models\Category','product_id','id');
    }

    public function product_image()
    {
        return $this->hasOne('App\Models\ProductImage','product_id','id');
    }
}
