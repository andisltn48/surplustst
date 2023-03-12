<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function product()
    {
        return $this->hasOne('App\Models\Product','product_id');
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category','category_id');
    }
}
