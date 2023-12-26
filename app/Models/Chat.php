<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'subject', 
        'can_respond', 
        'initiator', 
    ];

    public function chatParticipants() {
        return $this->hasMany(ChatParticipant::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'initiator', 'id');
    }
}
