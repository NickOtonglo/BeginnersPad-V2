<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HelpTicketLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->userActivityLog->email;
        $query = User::where('email', $this->userActivityLog->email)->first();
        if ($query) {
            $user = $query->username;
        }

        return [
            'id' => $this->id,
            'topic' => $this->topic, 
            'description' => $this->description, 
            'status' => $this->status, 
            'assigned_to' => $this->assigned_to, 
            'parent_id' => $this->parent_id, 
            'action_by' => $user, 
            'comment' => $this->comment,
            'time_ago' => $this->created_at->diffForHumans(),
        ];
    }
}
