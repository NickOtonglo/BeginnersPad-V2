<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFile extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'property_id'];

    public function property() {
        return $this->belongsTo(Property::class);
    }
}
