<?php

namespace App\Http\Resources\SubZone;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubZoneLogResource extends JsonResource
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
            'description' => $this->description,
            'nature_id' => $this->nature_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'radius' => $this->radius,
            'zone_id' => $this->zone_id,
            'comment' => $this->comment,
            'parent_id' => $this->parent_id,
            'action_by' => $username, 
            'comment' => $this->comment,
            'time_ago' => $this->created_at->diffForHumans(),
            'method' => $this->userActivityLog->method,
        ];
    }
}
