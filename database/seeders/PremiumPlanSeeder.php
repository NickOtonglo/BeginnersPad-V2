<?php

namespace Database\Seeders;

use App\Models\PremiumPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PremiumPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PremiumPlan::factory()
                ->count(1)
                ->state(new Sequence(
                    [
                        'name' => 'Waiting List',
                        'slug' => 'waiting-list',
                        'description' => 'Subscibe to a zone and receive instant updates when listings are published in that zone.',
                        'status' => 'active',
                        'minimum_days' => '14',
                        'price' => '100',
                    ],
                ))->create();
    }
}
