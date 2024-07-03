<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'username',
        'telephone',
        'role_id',
        'password',
        'avatar',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function articles() {
        return $this->hasMany(Article::class);
    }

    protected function role() {
        return $this->belongsTo(Role::class);
    }

    protected function brand() {
        return $this->hasOne(Brand::class);
    }

    public function properties() {
        return $this->hasMany(Property::class);
    }

    public function propertyReviews() {
        return $this->hasMany(PropertyReview::class, 'author_id', 'id');
    }

    public function userFavourites() {
        return $this->hasMany(UserFavourite::class);
    }

    public function helpTickets() {
        return $this->hasMany(HelpTicket::class, 'email', 'email');
    }

    public function assignedHelpTickets() {
        return $this->hasMany(HelpTicket::class, 'assigned_to', 'username');
    }

    public function logsParent() {
        return $this->hasMany(UserActivityLog::class, 'model_id', 'username');
    }

    public function notifications() {
        return $this->hasMany(Notification::class);
    }

    public function credit() {
        return $this->hasOne(UserCredit::class);
    }

    public function premiumSubscriptions() {
        return $this->hasMany(PremiumPlanSubscription::class);
    }

    public function waitingLists() {
        return $this->hasManyThrough(PremiumPlanWaitingList::class, PremiumPlanSubscription::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
