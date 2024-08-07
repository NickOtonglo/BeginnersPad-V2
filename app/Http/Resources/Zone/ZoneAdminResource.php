<?php

namespace App\Http\Resources\Zone;

use App\Http\Resources\Zone\ZoneLogResource;
use App\Http\Resources\ZoneCountiesResource;
use App\Models\ZoneLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoneAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $logs = [];
        foreach ($this->logsParent()->where('model', 'Zone')->get() as $item) {
            array_push($logs, $item->zoneLog);
        }

        $logsParent = [];
        foreach ($this->logsParent()->where('model', 'Zone')->get() as $item) {
            array_push($logsParent, $item);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'lat' => (float) $this->lat,
            'lng' => (float) $this->lng,
            'radius' => $this->radius*0.001,
            'timezone' => $this->timezone,
            'description' => $this->description,
            'timestamp' => $this->created_at->format('jS F Y'),
            'county_code' => $this->county_code,
            'county' => new ZoneCountiesResource($this->zoneCounty),
            'logs' => ZoneLogResource::collection($logs),
            'logs_parent' => $logsParent,
            'sub_zone_count' => $this->subZones()->count(),
            'property_count' => $this->properties()->where('status', '!=', 'unpublished')->count(),
        ];
    }
}
