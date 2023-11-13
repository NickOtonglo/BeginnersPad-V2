<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubZoneLog extends Model
{
    use HasFactory;

    public $table = 'logs_user_activity_sub_zones';
    protected $fillable = [
        'name',
        'description',
        'nature_id',
        'lat',
        'lng',
        'radius',
        'zone_id',
        'comment',
        'parent_id',
    ];

    public function userActivityLog() {
        return $this->belongsTo(UserActivityLog::class, 'parent_id', 'id');
    }
}
