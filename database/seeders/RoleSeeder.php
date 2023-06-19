<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()
                ->count(5)
                ->state(new Sequence(
                    [
                        'title' => 'System Admin',
                        'id' => '1.0',
                        'description' => ''
                    ],
                    [
                        'title' => 'Super Admin',
                        'id' => '2.0',
                        'description' => ''
                    ],
                    [
                        'title' => 'Admin',
                        'id' => '3.0',
                        'description' => ''
                    ],
                    [
                        'title' => 'Lister',
                        'id' => '4.0',
                        'description' => ''
                    ],
                    [
                        'title' => 'Beginner',
                        'id' => '5.0',
                        'description' => ''
                    ],
                    [
                        'title' => 'Unset',
                        'id' => '6.0',
                        'description' => ''
                    ],
                ))->create();
    }
}
