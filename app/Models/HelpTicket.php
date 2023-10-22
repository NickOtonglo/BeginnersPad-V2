<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpTicket extends Model
{
    use HasFactory;

    protected $filalble = ['email', 'topic', 'description', 'status', 'assigned_to'];

    public function user() {
        return $this->belongsTo(User::class, 'email');
    }

    public function admin() {
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

    public function logsParent() {
        return $this->hasMany(UserActivityLog::class, 'model_id');
    }
}
