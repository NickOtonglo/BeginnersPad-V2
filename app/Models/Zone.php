<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lat', 'lng', 'radius', 'timezone', 'description', 'county_code'];

    public function zoneCounty() {
        return $this->belongsTo(ZoneCounty::class, 'county_code', 'code');
    }

    public function subZones() {
        return $this->hasMany(SubZone::class);
    }

    public function logsParent() {
        return $this->hasMany(UserActivityLog::class, 'model_id', 'id');
    }

    public function properties() {
        return $this->hasManyThrough(Property::class, SubZone::class);
    }

    public function waitingLists() {
        return $this->hasMany(PremiumPlanWaitingList::class);
    }
}
