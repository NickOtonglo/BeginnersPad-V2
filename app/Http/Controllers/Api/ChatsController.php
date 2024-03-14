<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatResource;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class ChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = [];
        $myParticipants = ChatParticipant::where('user_id', auth()->user()->id)->latest()->get();
        foreach ($myParticipants as $participant) {
            $participant->chat = Chat::find($participant->chat_id);
            array_push($list, $participant->chat);
        }
        return ChatResource::collection($list);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        $isParticipant = false;
        $participants = $chat->chatParticipants;
        foreach ($participants as $participant) {
            if ($participant->user_id === auth()->user()->id) {
                $isParticipant = true;
            }
        }

        if ($isParticipant) {
            return new ChatResource($chat);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        $comment = '';
        $chatId = $chat->id;
        $chat->delete();

        $response = [
            'chats' => response()->noContent(),
            'model' => 'Chat',
            'key' => $chatId,
            'comment' => $comment,
            'message' => "Chat #'".$chatId."' deleted successfully.",
        ];
        return response($response, 201);
    }

    public function storeMessage(Chat $chat, Request $request) {
        $request->validate([
            'body' => 'required',
        ]);

        $participant = new stdClass;
        $participants = $chat->chatParticipants;
        foreach ($participants as $item) {
            if ($item->user_id === auth()->user()->id) {
                $participant = $item;
            }
        }

        $data = new ChatMessage;
        $data->body = $request->body;
        $data->chat_id = $chat->id;
        $data->participant_id = $participant->id;
        $data->save();

        MessageSent::dispatch($data);

        $comment = '';

        // $response = [
        //     'chat_message' => $data,
        //     'model' => 'ChatMessage',
        //     'key' => $data->id,
        //     'comment' => $comment,
        //     'message' => "Chat message #'".$data->id."' created successfully.",
        // ];

        $response = [
            'chat_message' => $data,
            'message' => "Chat message #'".$data->id."' created successfully.",
        ];
        return response($response, 201);

        /**https://stackoverflow.com/questions/3411495/php-get-a-single-key-from-object*/
        // return key((array)$request->all());
    }

    public function createChatFromListingEnquiry(User $sender, User $receiver, Property $property, Request $request) {
        $chat = new Chat;
        $chat->subject = "Enquiry on listing - ".$property->name;
        $chat->initiator = $sender->id;
        $chat->save();

        $this->createParticipant($sender->id, $chat->id);
        $this->createParticipant($receiver->id, $chat->id);
        $this->storeMessage($chat, $request);
    }

    public function createParticipant(int $userId, int $chatId) {
        $participant = new ChatParticipant;
        $participant->user_id = $userId;
        $participant->chat_id = $chatId;
        $participant->save();
    }
}
