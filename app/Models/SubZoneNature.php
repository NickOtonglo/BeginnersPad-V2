<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubZoneNature extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'description'];

    public $timestamps = false;

    public function subZoneNature() {
        return $this->hasMany(Zone::class);
    }
}
