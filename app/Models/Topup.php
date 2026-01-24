<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'reference',       // ✅ BUKAN reference_number
        'amount',
        'payment_method',
        'notes',
        'status',
        'user_ip',
    ];

    public function wallet()
    {
        return $this->belongsTo(\App\Models\Wallet::class);
    }
}
