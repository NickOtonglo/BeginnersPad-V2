<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HelpTicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $isLoggedIn = '';
        if ($this->user) {
            $isLoggedIn = true;

            return [
                'email' => null,
                'user' => $this->user->username,
                'isLoggedIn' => $isLoggedIn,
                'topic' => $this->topic, 
                'description' => $this->description, 
                'status' => $this->status, 
                'assigned_to' => $this->assigned_to
            ];
        }
        $isLoggedIn = false;
        return [
            'user' => null,
            'email' => $this->email,
            'isLoggedIn' => $isLoggedIn,
            'topic' => $this->topic, 
            'description' => $this->description, 
            'status' => $this->status, 
            'assigned_to' => $this->assigned_to
        ];  
    }
}
