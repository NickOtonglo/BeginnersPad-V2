<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'type', 
        'message_id', 
    ];

    public function chatMessage() {
        return $this->belongsTo(ChatMessage::class);
    }
}
