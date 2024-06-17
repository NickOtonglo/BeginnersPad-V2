<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCreditLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'credit', 'auto_pay', 'comment', 'parent_id'];

    public function userActivityLog() {
        return $this->belongsTo(UserActivityLog::class, 'parent_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
