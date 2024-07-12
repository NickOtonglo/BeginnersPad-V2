<?php

namespace App\Http\Resources\PremiumPlanSubscription;

use App\Http\Controllers\Api\SystemController;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PremiumPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $limit = '';

        if ($this->slug == 'waiting-list') {
            $limit = app(SystemController::class)->main(System::where('key', 'waiting_list_sub_limit')->first());
        }

        return [
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'minimum_days' => $this->minimum_days,
            'price' => $this->price,
            'sub_limit' => intval($limit->value),
        ];
    }
}
