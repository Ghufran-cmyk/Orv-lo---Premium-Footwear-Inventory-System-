<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    // Satu kategori memiliki banyak produk (hasMany)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}