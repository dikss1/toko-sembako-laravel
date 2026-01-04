<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name','email','password','role'
    ];

    protected $hidden = ['password','remember_token'];

    public function customer(): HasOne {
        return $this->hasOne(Customer::class);
    }

    public function transactions(): HasMany {
        return $this->hasMany(Transaction::class);
    }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }
}
