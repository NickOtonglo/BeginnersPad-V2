<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyLog extends Model
{
    use HasFactory;

    public $table = 'logs_user_activity_properties';
    protected $fillable = [
        'name',
        'slug',
        'lat',
        'lng',
        'status',
        'verified',
        'description',
        'thumbnail',
        'user_id',
        'sub_zone_id',
        'comment',
        'parent_id',
    ];

    public function userActivityLog() {
        return $this->belongsTo(UserActivityLog::class, 'parent_id', 'id');
    }
}
