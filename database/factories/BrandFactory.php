<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->lastName;
        $userId = User::where('role_id', 4)->pluck('id');

        return [
            'name' => $name,
            'statement' => fake()->paragraph(),
            'avatar' => time().'-'.$name.'.jpg',
            'user_id' => $userId->random(),
        ];
    }
}
