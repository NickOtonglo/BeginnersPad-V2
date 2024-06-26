<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCredit extends Model
{
    use HasFactory;

    protected $fillable = ['credit', 'auto_pay', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
