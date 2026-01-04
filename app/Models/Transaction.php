<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'kode','user_id','customer_id','tanggal',
        'delivery_method','shipping_fee','subtotal','total',
        'payment_status','payment_proof_path','paid_at','status'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'tanggal' => 'date',
    ];

    public function items(): HasMany {
        return $this->hasMany(TransactionItem::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }
}
