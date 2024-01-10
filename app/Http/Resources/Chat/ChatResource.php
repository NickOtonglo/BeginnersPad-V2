<?php

namespace App\Http\Resources\Chat;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $canRespond = '';
        if ($this->can_respond == 0) {
            $canRespond = 'false';
        } else {
            $canRespond = 'true';
        }

        $list = [];
        $authParticipant = new stdClass();
        // $participants = $this->chatParticipants;
        $participants = $this->chatParticipants()->latest()->get();
        foreach ($participants as $item) {
            if ($item->user_id !== auth()->user()->id) {
                array_push($list, $item);
            } else {
                $authParticipant = $item;
            }
        }
        if ($authParticipant) {
            array_push($list, $authParticipant);
        }
        
        return [
            'id' => $this->id, 
            'subject' => $this->subject, 
            'initiator' => (User::find($this->initiator)->username), 
            'can_respond' => $canRespond, 
            'participants' => ChatParticipantResource::collection($list), 
            'messages' => ChatMessageResource::collection($this->chatMessages), 
        ];
    }
}
