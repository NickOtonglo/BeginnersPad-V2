<?php

namespace Database\Seeders;

use App\Models\HelpTopic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class HelpTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HelpTopic::factory()
                ->count(6)
                ->state(new Sequence(
                    [
                        'category' => 'Billing',
                        'description' => null,
                        'priority' => '5',
                    ],
                    [
                        'category' => 'My account',
                        'description' => null,
                        'priority' => '5',
                    ],
                    [
                        'category' => 'Signing in',
                        'description' => null,
                        'priority' => '5',
                    ],
                    [
                        'category' => 'Signing up',
                        'description' => null,
                        'priority' => '5',
                    ],
                    [
                        'category' => 'Account suspended',
                        'description' => null,
                        'priority' => '5',
                    ],
                    [
                        'category' => 'Other',
                        'description' => null,
                        'priority' => '5',
                    ],
                ))->create();
    }
}
