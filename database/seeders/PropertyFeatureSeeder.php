<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyFeature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PropertyFeature::factory(90)->create();
    }
}
