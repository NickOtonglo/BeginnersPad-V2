<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLogResource extends JsonResource
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
            'firstname' => $this->firstname, 
            'lastname' => $this->lastname, 
            // 'email' => $this->email, 
            'username' => $this->username, 
            'telephone' => $this->telephone, 
            'parent_id' => $this->parent_id, 
            'action_by' => $username, 
            'comment' => $this->comment,
            'status' => $this->status,
            'time_ago' => $this->created_at->diffForHumans(),
            'method' => $this->userActivityLog->method,
        ];
    }
}
