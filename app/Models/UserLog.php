<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    public $table = 'logs_user_activity_users';
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'username',
        'telephone',
        'comment',
        'parent_id',
        'user_id', 
    ];

    public function userActivityLog() {
        return $this->belongsTo(UserActivityLog::class, 'parent_id', 'id');
    }
}
