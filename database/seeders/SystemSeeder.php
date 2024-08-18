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
                ->count(6)
                ->state(new Sequence(
                    [
                        'key' => 'property_unit_max_rent',
                        'value' => '30000',
                    ],
                    [
                        'key' => 'waiting_list_sub_limit',
                        'value' => '5',
                    ],
                    [
                        'key' => 'user_credit_free',
                        'value' => 'false',
                    ],
                    [
                        'key' => 'user_credit_user_roles',
                        'value' => '[5]',
                    ],
                    [
                        'key' => 'user_credit_amount',
                        'value' => '0',
                    ],
                    [
                        'key' => 'user_credit_daily_limit',
                        'value' => '0',
                    ],
                ))->create();
    }
}
