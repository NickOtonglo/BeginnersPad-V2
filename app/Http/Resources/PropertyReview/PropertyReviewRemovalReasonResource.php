<?php

namespace App\Http\Resources\PropertyReview;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyReviewRemovalReasonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->id,
            'reason' => $this->reason,
            'comments' => $this->comments,
        ];
    }
}
