<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $guarded = ['id'];

    // Kembali ke header Penjualan
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Relasi ke Produk apa yang dijual
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}