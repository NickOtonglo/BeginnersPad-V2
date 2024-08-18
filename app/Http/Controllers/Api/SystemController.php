<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\System;
use Database\Seeders\SystemSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SystemController extends Controller
{
    public function main(System $key) {
        return $key;
    }

    public function reset() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('system')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $seeder = new SystemSeeder;
        $seeder->run();

        $response = [
            'system' => null,
            'model' => 'System',
            'key' => null,
            'message' => "System settings reset",
            'comment' => 'System settings reset',
        ];
        return response($response, 201);
    }
}
