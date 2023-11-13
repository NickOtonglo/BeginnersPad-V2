<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;

    public $table = 'logs_user_activity';
    protected $fillable = [
        'email', 
        'is_registered', 
        'ip_address', 
        'url', 
        'method', 
        'client', 
        'model', 
        'model_id', 
    ];

    public function helpTicket() {
        return $this->belongsTo(HelpTicket::class, 'model_id');
    }

    public function helpTicketLog() {
        return $this->hasOne(HelpTicketLog::class, 'parent_id', 'id');
    }

    public function faqLog() {
        return $this->hasOne(FAQLog::class, 'parent_id', 'id');
    }

    public function userLog() {
        return $this->hasOne(UserLog::class, 'parent_id', 'id');
    }

    public function zoneLog() {
        return $this->hasOne(ZoneLog::class, 'parent_id', 'id');
    }

    public function subZoneLog() {
        return $this->hasOne(SubZoneLog::class, 'parent_id', 'id');
    }

    public function propertyLog() {
        return $this->hasOne(PropertyLog::class, 'parent_id', 'id');
    }
}
