<?php

namespace App\Http\Resources\PropertyReview;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyReviewRemovalLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->userActivityLog->email;
        $query = User::where('email', $this->userActivityLog->email)->first();
        if ($query) {
            $user = $query->username;
        }
        
        return [
            'id' => $this->id,
            'review' => $this->review,
            'rating' => $this->rating,
            'author_id' => $this->author_id,
            'property_id' => $this->property_id,
            'removal_reason' => $this->removal_reason,
            'reason_details' => $this->removal_details,
            'parent_id' => $this->parent_id,
            'action_by' => $user, 
            'comment' => $this->comment,
            'time_ago' => $this->created_at->diffForHumans(),
        ];
    }
}
