<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyUnitFile extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type', 'property_unit_id'];

    public function propertyUnit() {
        return $this->belongsTo(PropertyUnit::class);
    }
}
