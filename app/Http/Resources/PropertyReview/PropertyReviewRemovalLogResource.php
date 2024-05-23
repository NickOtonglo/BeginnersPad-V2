<?php

namespace App\Http\Resources\PropertyReview;

use App\Models\Property;
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
        $username = '';
        $query = User::where('email', $this->userActivityLog->email)->first();
        if ($query) {
            $username = $query->username;
        }

        $query = User::where('email', $this->userActivityLog->email)->first();
        if ($query) {
            $user = $query->username;
        }
        $author = User::find($this->author_id);
        $property = Property::find($this->property_id);
        
        return [
            'id' => $this->id,
            'review' => $this->review,
            'rating' => $this->rating,
            'author_username' => $author->username,
            'property_name' => $property->name,
            'property_slug' => $property->slug,
            'removal_reason' => $this->removal_reason,
            'reason_details' => $this->reason_details,
            // 'parent_id' => $this->parent_id,
            'action_by' => $username, 
            'comment' => $this->comment,
            'timestamp' => $this->created_at->format('jS F Y, H:m:s'),
            'time_ago' => $this->created_at->diffForHumans(),
        ];
    }
}
