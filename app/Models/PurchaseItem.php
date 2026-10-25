<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $guarded = ['id'];

    // Kembali ke header Pembelian
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    // Relasi ke Produk apa yang dibeli
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}