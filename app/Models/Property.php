<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'lat',
        'lng',
        'status',
        'verified',
        'description',
        'stories',
        'thumbnail',
        'user_id',
        'sub_zone_id',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function subZone() {
        return $this->belongsTo(SubZone::class);
    }

    public function propertyFeature() {
        return $this->hasMany(PropertyFeature::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
