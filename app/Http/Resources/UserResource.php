<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'username' => $this->username,
            'telephone' => $this->telephone,
            'role_id' => $this->role_id,
            'avatar' => $this->avatar,
            'status' => $this->status,
            'created_at' => $this->created_at->format('j F Y'),
            'brand' => new BrandResource($this->brand),
        ];
    }
}
