<?php

namespace App\Http\Resources\PropertyUnit;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyUnitLogResource extends JsonResource
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
            'description' => $this->description,
            'price' => $this->price,
            'init_deposit' => $this->init_deposit,
            'init_deposit_period' => $this->init_deposit_period,
            'story' => $this->story,
            'floor_area' => $this->floor_area,
            'bathrooms' => $this->bathrooms,
            'bedrooms' => $this->bedrooms,
            'disclaimer' => $this->disclaimer,
            'status' => $this->status,
            'thumbnail' => $this->thumbnail,
            'property_id' => $this->property_id,
            'action_by' => $username, 
            'comment' => $this->comment,
            'time_ago' => $this->created_at->diffForHumans(),
            'method' => $this->userActivityLog->method,
        ];
    }
}
