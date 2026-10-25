<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded = ['id'];

    // Satu supplier bisa memiliki banyak riwayat pembelian/barang masuk (hasMany)
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}