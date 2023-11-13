<?php

namespace App\Http\Resources\Zone;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoneLogResource extends JsonResource
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
            'lat' => $this->lat,
            'lng' => $this->lng,
            'radius' => $this->radius,
            'timezone' => $this->timezone,
            'county_code' => $this->county_code,
            'action_by' => $username, 
            'comment' => $this->comment,
            'time_ago' => $this->created_at->diffForHumans(),
            'method' => $this->userActivityLog->method,
        ];
    }
}
