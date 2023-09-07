<?php

namespace Database\Factories;

use App\Models\PropertyUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyUnitFeature>
 */
class PropertyUnitFeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unitId = PropertyUnit::pluck('id');

        return [
            'item' => $this->faker->text(100),
            'property_unit_id' => $unitId->random(),
        ];
    }
}
