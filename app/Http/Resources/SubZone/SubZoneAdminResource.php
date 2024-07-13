<?php

namespace App\Http\Resources\SubZone;

use App\Http\Resources\SubZoneNatureResource;
use App\Http\Resources\ZonesResource;
use App\Models\SubZoneLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubZoneAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $logs = [];
        foreach ($this->logsParent()->where('model', 'SubZone') as $item) {
            array_push($logs, $item->subZoneLog);
        }

        $logsParent = [];
        foreach ($this->logsParent()->where('model', 'SubZone') as $item) {
            array_push($logsParent, $item);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'lat' => (float) $this->lat,
            'lng' => (float) $this->lng,
            'radius' => $this->radius*0.001,
            'description' => $this->description,
            'timestamp' => $this->created_at->format('jS F Y'),
            'nature_id' => $this->nature_id,
            'zone_id' => $this->zone_id,
            'nature' => new SubZoneNatureResource($this->nature),
            'zone' => new ZonesResource($this->zone),
            'logs' => SubZoneLogResource::collection($logs),
            'logs_parent' => $logsParent,
        ];
    }
}
