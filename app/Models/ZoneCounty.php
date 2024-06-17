<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneCounty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'country_id'];

    public function getRouteKeyName() {
        return 'code';
    }

    public function zoneCountry() {
        return $this->belongsTo(ZoneCountry::class, 'country_id');
    }

    public function zones() {
        return $this->hasMany(Zone::class, 'county_code');
    }
}
