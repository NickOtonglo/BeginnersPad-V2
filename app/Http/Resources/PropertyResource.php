<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'user_id' => $this->user_id,
            'sub_zone_id' => $this->sub_zone_id,
            'status' => $this->status,
            'verified' => $this->verified,
            'description' => $this->description,
            'stories' => $this->stories,
            'thumbnail' => $this->thumbnail,
            'timestamp' => $this->created_at->format('jS F Y,  H:m:s'),
            'time_ago' => $this->created_at->diffForHumans(),
            'sub_zone' => new SubZoneResource($this->subZone),
        ];
    }
}
