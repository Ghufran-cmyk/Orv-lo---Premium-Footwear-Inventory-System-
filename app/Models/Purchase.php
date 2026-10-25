<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = ['id'];

    // Relasi ke Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relasi ke User (Staff/Admin yang menginput)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Detail Pembelian (1 Pembelian punya banyak Item)
    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}