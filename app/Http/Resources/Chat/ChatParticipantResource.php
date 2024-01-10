<?php

namespace App\Http\Resources\Chat;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatParticipantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $username = '';
        $avatar = '';
        $user = User::where('id', $this->user_id)->first();
        if ($user) {
            $username = $user->username;
            $avatar = $user->avatar;
        }

        return [
            'participant' => $username, 
            'avatar' => $avatar, 
            'last_read' => $this->last_read, 
            'last_read_ago' => $this->updated_at->diffForHumans(), 
        ];
    }
}
