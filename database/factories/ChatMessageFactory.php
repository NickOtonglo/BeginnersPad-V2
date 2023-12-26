<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\ChatParticipant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChatMessage>
 */
class ChatMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $chatId = Chat::pluck('id');
        $participantId = ChatParticipant::pluck('id');

        return [
            'body' => $this->faker->text(rand(5, 500)), 
            'type' => 'text', 
            'reply_message_id' => null, 
            'chat_id' => $chatId->random(), 
            'participant_id' => $participantId->random(), 
        ];
    }
}
