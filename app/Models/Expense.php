<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'wallet_id',
        'expense_group_id',
        'amount',
        'description',
    ];
}
