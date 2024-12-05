<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',

    ];

    public function products()
    {
        //Quan hệ 1-n
        return $this->hasMany(Product::class);
    }
}
