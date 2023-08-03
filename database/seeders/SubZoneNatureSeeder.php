<?php

namespace Database\Seeders;

use App\Models\SubZoneNature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class SubZoneNatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubZoneNature::factory()
                ->count(4)
                ->state(new Sequence(
                    [
                        'category' => 'Residential',
                        'description' => '',
                    ],
                    [
                        'category' => 'Commercial',
                        'description' => '',
                    ],
                    [
                        'category' => 'Industrial',
                        'description' => '',
                    ],
                    [
                        'category' => 'Other',
                        'description' => '',
                    ],
                ))->create();
    }
}
