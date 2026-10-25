<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes; // Mengaktifkan fitur soft delete sesuai syarat UTS

    protected $guarded = ['id'];

    // Setiap produk dimiliki oleh satu kategori (belongsTo)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke detail transaksi
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}