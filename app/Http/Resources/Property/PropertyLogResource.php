<?php

namespace App\Http\Resources\Property;

use App\Models\PropertyLog;
use App\Models\SubZone;
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
        $suspended_count = PropertyLog::where('slug', $this->slug)->where('status', 'suspended')->count();
        $subZone = SubZone::find($this->sub_zone_id);
        $zone = $subZone->zone;
        $county = $zone->zoneCounty;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'lat' => (float) $this->lat,
            'lng' => (float) $this->lng,
            'status' => $this->status,
            'verified' => $this->verified,
            'description' => $this->description,
            'stories' => $this->stories,
            'thumbnail' => $this->thumbnail,
            'lister' => User::where('id', $this->user_id)->first()->username,
            'sub_zone' => $subZone->name,
            'zone' => $zone->name,
            'county' => $county->name, 
            'action_by' => $username, 
            'comment' => $this->comment,
            'timestamp' => $this->created_at->format('jS F Y, H:m:s'),
            'time_ago' => $this->created_at->diffForHumans(),
            'method' => $this->userActivityLog->method,
            'suspended_count' => $suspended_count,
        ];
    }
}
