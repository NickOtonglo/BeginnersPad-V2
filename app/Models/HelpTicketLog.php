<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpTicketLog extends Model
{
    use HasFactory;

    public $table = 'logs_user_activity_help_tickets';
    protected $fillable = [
        'topic', 
        'description', 
        'status', 
        'assigned_to', 
        'parent_id', 
    ];

    public function userActivityLog() {
        return $this->belongsTo(UserActivityLog::class, 'parent_id', 'id');
    }

}
