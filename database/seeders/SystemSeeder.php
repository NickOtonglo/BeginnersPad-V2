<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        System::factory()
                ->count(1)
                ->state(new Sequence(
                    [
                        'key' => 'waiting_list_sub_limit',
                        'value' => 5,
                    ]
                ))->create();
    }
}
