<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumPlanSubscriptionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'activated_at',
        'expires_at',
        'user_id',
        'premium_plan_id',
        'premium_plan_name',
        'premium_plan_minimum_period',
        'premium_plan_price',
        'comment',
        'parent_id',
    ];

    public function userActivityLog() {
        return $this->belongsTo(UserActivityLog::class, 'parent_id', 'id');
    }
}
