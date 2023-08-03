<?php

namespace Database\Factories;

use App\Models\SubZoneNature;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubZone>
 */
class SubZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = str_replace(array('.',''), '',ucwords($this->faker->lexify('??????')));
        $subZoneNature = SubZoneNature::pluck('id');
        $zone = Zone::pluck('id');

        return [
            'name' => $name,
            'lat' => 0.0000,
            'lng' => 0.0000,
            'radius' => 1000,
            'description' => $this->faker->paragraph(2, true),
            'nature_id' => $subZoneNature->random(),
            'zone_id' => $zone->random(),
        ];
    }
}
