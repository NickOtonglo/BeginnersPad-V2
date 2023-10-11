<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HelpFAQ>
 */
class FAQFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $topic = ['account', 'billing', 'listings', 'help'];
        
        return [
            'question' => $this->faker->text(rand(25, 110)), 
            'answer' => $this->faker->text(rand(250, 750)), 
            'topic' => $topic[rand(0, count($topic)-1)]
        ];
    }
}
