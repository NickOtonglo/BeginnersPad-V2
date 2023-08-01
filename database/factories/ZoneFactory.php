<?php

namespace Database\Factories;

use App\Models\ZoneCounty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Zone>
 */
class ZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = str_replace(array('.',''), '',ucwords($this->faker->lexify('???????')));
        $countyCode = ZoneCounty::pluck('code');

        return [
            'name' => $name,
            'lat' => 0.0000,
            'lng' => 0.0000,
            'radius' => 5000,
            'timezone' => 'GMT+3',
            'description' => $this->faker->paragraph(2, true),
            'county_code' => $countyCode->random(),
        ];
    }
}
