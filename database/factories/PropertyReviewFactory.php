<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class PropertyReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $authorID = User::where('role_id', 5)->pluck('id');
        $randomPropertyId = Property::pluck('id')->random();
        $property = Property::where('id', $randomPropertyId)->first();
        
        return [
            'review' => $this->faker->text(rand(100,1000)), 
            'rating' => rand(1, 5), 
            'author_id' => $authorID->random(), 
            'property_id' => $property->id,
        ];
    }
}
