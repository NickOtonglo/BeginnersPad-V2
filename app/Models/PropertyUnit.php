<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyUnit extends Model
{
    use HasFactory;

    protected $filalble = [
        'name',
        'slug',
        'description',
        'price',
        'init_deposit',
        'init_deposit_period',
        'story',
        'floor_area',
        'disclaimer',
        'status',
        'thumbnail',
        'property_id',
    ];

    public function property() {
        return $this->belongsTo(Property::class);
    }
}
