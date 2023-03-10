<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
}
