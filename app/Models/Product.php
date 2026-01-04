<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['nama','stok','harga','satuan','deskripsi'];

    public function items(): HasMany {
        return $this->hasMany(TransactionItem::class);
    }
}
