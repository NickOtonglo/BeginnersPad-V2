<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumPlanWaitingList extends Model
{
    use HasFactory;

    protected $fillable = ['subscription_id', 'zone_id'];

    public function premiumPlanSubscription() {
        return $this->belongsTo(PremiumPlanSubscription::class, 'id', 'subscription_id');
    }

    public function zone() {
        return $this->belongsTo(Zone::class);
    }
}
