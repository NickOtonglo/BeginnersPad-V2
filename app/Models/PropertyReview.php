<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyReview extends Model
{
    use HasFactory;

    protected $fillable = ['review', 'rating', 'author_id', 'property_id'];

    public function property() {
        return $this->belongsTo(Property::class);
    }
}
