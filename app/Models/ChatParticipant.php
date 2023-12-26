<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'chat_id', 
        'last_read', 
    ];

    public function chat() {
        return $this->belongsTo(Chat::class);
    }
}
