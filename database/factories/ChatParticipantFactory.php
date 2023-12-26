<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\ChatParticipant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChatParticipant>
 */
class ChatParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $userId = User::pluck('id');
        // $user = $userId->random();
        // $chatId = Chat::pluck('id');
        // $chat = $chatId->random();
        // $firstParticipant = ChatParticipant::where('chat_id', $chat)->oldest()->first();
        // $originalChat = Chat::where('id', $chat)->first();

        // if ($firstParticipant && $firstParticipant->user_id === $originalChat->initiator) {
        //     return [
        //         'user_id' => $user, 
        //         'chat_id' => $chat, 
        //         'last_read' => now(), 
        //     ];
        // }

        // if (!ChatParticipant::where('chat_id', $chat)->get()->count() > 2) {
        // }
        // return [
        //     'user_id' => $originalChat->initiator, 
        //     'chat_id' => $originalChat->id, 
        //     'last_read' => now(), 
        // ];

        return [
            'user_id' => User::pluck('id')->random(), 
            'chat_id' => Chat::pluck('id')->random(), 
            'last_read' => now(),
        ]; 
    }
}
