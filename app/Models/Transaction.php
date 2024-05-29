<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'confirmation_code',
        'amount',
        'comment',
        'user_id',
        'payment_gateway_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
