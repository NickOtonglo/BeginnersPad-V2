<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyUnitLog extends Model
{
    use HasFactory;

    public $table = 'logs_user_activity_property_units';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'init_deposit',
        'init_deposit_period',
        'story',
        'floor_area',
        'bathrooms',
        'bedrooms',
        'disclaimer',
        'status',
        'thumbnail',
        'property_id',
        'comment',
        'parent_id',
    ];

    public function userActivityLog() {
        return $this->belongsTo(UserActivityLog::class, 'parent_id', 'id');
    }
}
