<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseGroup extends Model
{
    protected $fillable = [
        'name',
        'title',
        'user_id',
    ];
}
