<?php

namespace Database\Seeders;

use App\Models\PropertyUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PropertyUnit::factory(50)->create();
    }
}
