<?php

namespace Database\Seeders;

use App\Models\ZoneCountry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ZoneCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ZoneCountry::factory()
                ->count(1)
                ->state(new Sequence(
                    [
                        'name' => 'Kenya',
                        'initials' => 'KE',
                    ]
                ))->create();
    }
}
