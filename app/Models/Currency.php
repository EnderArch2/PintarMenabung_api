<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    protected $fillable = [
        'name',
        'symbol',
        'code'
    ];

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }
}
