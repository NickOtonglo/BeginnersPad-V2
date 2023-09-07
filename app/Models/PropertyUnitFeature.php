<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyUnitFeature extends Model
{
    use HasFactory;
    protected $fillable = ['item', 'property_unit_id'];

    public function propertyUnit() {
        return $this->belongsTo(PropertyUnit::class);
    }
}
