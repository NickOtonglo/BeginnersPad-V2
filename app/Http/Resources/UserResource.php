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
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'username' => $this->username,
            'telephone' => $this->telephone,
            'role_id' => $this->role_id,
            'avatar' => $this->avatar,
            'password' => $this->password,
            'created_at' => $this->created_at->format('j F Y'),
            'updated_at' => $this->updated_at->format('j F Y'),
        ];
    }
}
