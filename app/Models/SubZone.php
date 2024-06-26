<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubZone extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'lat', 'lng', 'radius', 'nature_id', 'zone_id'];

    public function zone() {
        return $this->belongsTo(Zone::class);
    }

    public function nature() {
        return $this->belongsTo(SubZoneNature::class, 'nature_id');
    }

    public function properties() {
        return $this->hasMany(Property::class);
    }

    public function logsParent() {
        return $this->hasMany(UserActivityLog::class, 'model_id', 'id');
    }

    public function propertyUnits() {
        return $this->hasManyThrough(PropertyUnit::class, Property::class);
    }
}
