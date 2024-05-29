<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumPlanSubscription extends Model
{
    use HasFactory;
    protected $fillable = ['period', 'activated_at', 'user_id', 'premium_plan_id'];

    public function premiumPlan() {
        return $this->belongsTo(PremiumPlan::class);
    }
}
