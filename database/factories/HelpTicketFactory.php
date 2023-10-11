<?php

namespace Database\Factories;

use App\Models\HelpTopic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HelpTicket>
 */
class HelpTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $userEmail = '';
        $userRandom = rand(0, 9);
        if ($userRandom % 2 == 0) {
            $userPluck = User::where('role_id', rand(4,5))->pluck('email')->toArray();
            // $userEmail = $userPluck()->random();
            $userEmail = $userPluck[rand(0, count($userPluck)-1)];
        } else {
            $userEmail = fake()->email();
        }
        $topic = HelpTopic::pluck('category')->toArray();

        return [
            'email' => $userEmail, 
            'topic' => $topic[rand(0, count($topic)-1)], 
            'description' => $this->faker->text(rand(300, 1500)), 
            // 'status' => 'open', 
            // 'assigned_to' => '',
        ];
    }
}
