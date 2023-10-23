<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQLog extends Model
{
    use HasFactory;

    public $table = 'logs_user_activity_faq';
    protected $fillable = [
        'question', 
        'answer', 
        'topic', 
        'parent_id', 
        'comment', 
    ];

    public function userActivityLog() {
        return $this->belongsTo(UserActivityLog::class);
    }
}
