<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentGateway::factory()
                ->count(1)
                ->state(new Sequence(
                    [
                        'id' => 1,
                        'name' => 'M-Pesa',
                    ],
                ))->create();
    }
}
