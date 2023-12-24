<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyUnit;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyUnit>
 */
class PropertyUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomPropertyId = Property::pluck('id')->random();
        $property = Property::where('id', $randomPropertyId)->first();
        $level = rand(1, $property->stories);
        $name = 'F0'.rand(1, 20).$level;
        $slug = Str::slug($name, '-');

        if (PropertyUnit::where('slug', $slug)->first()) {
            $slug = Str::slug($name, '-').'-'.time();
        }

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->text(300),
            'price' => rand(2000, 30000),
            'init_deposit' => rand(2000, 60000),
            'init_deposit_period' => rand(0, 6),
            'story' => $level,
            'floor_area' => rand(20,200),
            'bathrooms' => rand(1,2),
            'bedrooms' => rand(1,2),
            'disclaimer' => $this->faker->text(100),
            'status' => 'active',
            // 'thumbnail' => null,
            'property_id' => $property->id,
        ];
    }
}
