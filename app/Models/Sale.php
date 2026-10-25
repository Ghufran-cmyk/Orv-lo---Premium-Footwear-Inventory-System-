<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['id'];

    // Relasi ke User (Staff kasir atau Customer yang checkout)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Detail Penjualan
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}