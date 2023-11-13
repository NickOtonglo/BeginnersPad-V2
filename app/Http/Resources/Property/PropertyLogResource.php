<?php

namespace App\Http\Resources\Property;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyLogResource extends JsonResource
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

        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'status' => $this->status,
            'verified' => $this->verified,
            'description' => $this->description,
            'stories' => $this->stories,
            'thumbnail' => $this->thumbnail,
            'user_id' => $this->user_id,
            'sub_zone_id' => $this->sub_zone_id,
            'action_by' => $username, 
            'comment' => $this->comment,
            'time_ago' => $this->created_at->diffForHumans(),
            'method' => $this->userActivityLog->method,
        ];
    }
}
