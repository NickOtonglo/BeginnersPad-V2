<?php

namespace Database\Seeders;

use App\Models\PropertyUnit;
use App\Models\PropertyUnitFeature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyUnitFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PropertyUnitFeature::factory(90)->create();
    }
}
