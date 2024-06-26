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
        'address',
        'lat',
        'lng',
        'status',
        'verified',
        'description',
        'stories',
        'thumbnail',
        'user_id',
        'sub_zone_id',
        'published_at'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function subZone() {
        return $this->belongsTo(SubZone::class);
    }

    public function propertyFeatures() {
        return $this->hasMany(PropertyFeature::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function propertyFiles() {
        return $this->hasMany(PropertyFile::class);
    }

    public function propertyUnits() {
        return $this->hasMany(PropertyUnit::class);
    }

    public function propertyReviews() {
        return $this->hasMany(PropertyReview::class);
    }

    public function logsParent() {
        return $this->hasMany(UserActivityLog::class, 'model_id', 'id');
    }
}
