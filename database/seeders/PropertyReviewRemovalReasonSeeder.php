<?php

namespace Database\Seeders;

use App\Models\PropertyReviewRemovalReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PropertyReviewRemovalReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PropertyReviewRemovalReason::factory()
                ->count(10)
                ->state(new Sequence(
                    [
                        'reason' => 'spam',
                        'comments' => ''
                    ],
                    [
                        'reason' => 'advertising',
                        'comments' => ''
                    ],
                    [
                        'reason' => 'offensive language',
                        'comments' => ''
                    ],
                    [
                        'reason' => 'violent or threatening language',
                        'comments' => ''
                    ],
                    [
                        'reason' => 'bullying',
                        'comments' => ''
                    ],
                    [
                        'reason' => 'racism',
                        'comments' => ''
                    ],
                    [
                        'reason' => 'fraudulent behaviour',
                        'comments' => ''
                    ],
                    [
                        'reason' => 'child abuse',
                        'comments' => ''
                    ],
                    [
                        'reason' => 'pornography',
                        'comments' => ''
                    ],
                    [
                        'reason' => 'other',
                        'comments' => ''
                    ],
                ))->create();
    }
}
