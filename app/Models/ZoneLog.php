<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneLog extends Model
{
    use HasFactory;

    public $table = 'logs_user_activity_zones';
    protected $fillable = [
        'name',
        'description',
        'lat',
        'lng',
        'radius',
        'timezone',
        'county_code',
        'comment',
        'parent_id',
    ];

    public function userActivityLog() {
        return $this->belongsTo(UserActivityLog::class, 'parent_id', 'id');
    }

}
