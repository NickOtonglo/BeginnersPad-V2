<?php

namespace App\Http\Resources;

use App\Models\User;
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
        $logs = [];
        foreach ($this->logsParent as $item) {
            array_push($logs, $item->helpTicketLog);
        }

        $logsParent = [];
        foreach ($this->logsParent as $item) {
            array_push($logsParent, $item);
        }

        $user = User::where('email', $this->email)->first();
        // $responder = User::where('username', $this->assigned_to)->first();
        $isRegistered = '';
        if ($user) {
            $isRegistered = true;

            return [
                'id' => $this->id,
                'email' => null,
                'user' => $user->username,
                'isRegistered' => $isRegistered,
                'topic' => $this->topic, 
                'description' => $this->description, 
                'status' => $this->status, 
                'assigned_to' => $this->assigned_to,
                'timestamp' => $this->created_at->format('jS F Y, H:m:s'),
                'time_ago' => $this->created_at->diffForHumans(),
                'logs_parent' => $logsParent,
                'logs' => HelpTicketLogResource::collection($logs),
            ];
        }
        $isRegistered = false;
        return [
            'id' => $this->id,
            'user' => null,
            'email' => $this->email,
            'isRegistered' => $isRegistered,
            'topic' => $this->topic, 
            'description' => $this->description, 
            'status' => $this->status, 
            'assigned_to' => $this->assigned_to,
            'timestamp' => $this->created_at->format('jS F Y, H:m:s'),
            'time_ago' => $this->created_at->diffForHumans(),
            'logs_parent' => $logsParent,
            'logs' => HelpTicketLogResource::collection($logs),
        ];  
    }
}
