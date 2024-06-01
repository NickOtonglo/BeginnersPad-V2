<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'status', 'minimum_days', 'price'];

    public function premiumPlanSubscriptions() {
        return $this->hasMany(PremiumPlanSubscription::class);
    }
}
