<?php

namespace App\Http\Resources\Chat;

use App\Models\ChatFile;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @var object $replyMsg
     */
    public function toArray(Request $request): array
    {
        $file = '';
        if ($this->type !== 'text') {
            $file = new ChatFileResource(ChatFile::where('message_id', $this->id)->first());
        }

        $replyMsg = new stdClass();
        $replyMsg->body = '';
        $replyMsg->file = '';
        if ($this->reply_message_id) {
            $replyMsg = ChatMessage::where('id', $this->reply_message_id)->first();
            if ($replyMsg->type !== 'text') {
                $replyMsg->file = new ChatFileResource(ChatFile::where('message_id', $replyMsg->id)->first());
            }
        }

        return [
            'body' => $this->body, 
            'type' => $this->type, 
            'file' => $file, 
            'reply_message' => [
                'body' => $replyMsg->body,
                'file' => $replyMsg->file,
            ], 
            'participant' => new ChatParticipantResource(ChatParticipant::find($this->participant_id)), 
            'timestamp' => $this->created_at->format('jS F Y, H:m:s'), 
            'time_ago' => $this->created_at->diffForHumans(), 
        ];
    }
}
