<?php

namespace Database\Factories;

use App\Models\SubZone;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->streetName();
        $slug = Str::slug($name, '-');
        $userID = User::where('role_id', 4)->pluck('id');
        $subZoneID = SubZone::pluck('id');

        return [
            'name' => $name,
            'slug' => $slug,
            'lat' => 1.00000001,
            'lng' => 1.00000001,
            'status' => 'unpublished',
            'verified' => false,
            'description' => $this->faker->text(300),
            'thumbnail' => time().'-'.$slug.'.jpg',
            'user_id' => $userID->random(),
            'sub_zone_id' => $subZoneID->random(),
        ];
    }
}
