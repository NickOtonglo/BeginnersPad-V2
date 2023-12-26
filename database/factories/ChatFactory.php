<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::get()->pluck('id');
        return [
            'subject' => fake()->jobTitle(),
            'can_respond' => rand(0, 1), 
            'initiator' => $userId->random(), 
        ];
    }
}
