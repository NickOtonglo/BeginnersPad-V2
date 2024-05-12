<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyReviewRemovalLog extends Model
{
    use HasFactory;

    public $table = 'logs_user_activity_property_review_removal';
    protected $fillable = [
        'review', 
        'rating', 
        'author_id', 
        'property_id', 
        'removal_reason', 
        'reason_details', 
        'comment', 
        'parent_id'
    ];

    public function userActivityLog() {
        return $this->belongsTo(UserActivityLog::class, 'parent_id', 'id');
    }
}
