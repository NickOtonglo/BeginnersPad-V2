<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'body', 
        'type', 
        'reply_message_id', 
        'chat_id', 
        'participant_id', 
    ];

    public function chat() {
        return $this->belongsTo(Chat::class);
    }

    public function chatFiles() {
        return $this->hasOne(ChatFile::class);
    }
}
