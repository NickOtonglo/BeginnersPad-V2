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
}