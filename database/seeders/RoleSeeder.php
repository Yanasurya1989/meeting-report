<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['name' => 'direktur'],
            ['name' => 'kabid1'],
            ['name' => 'kabid2'],
            ['name' => 'kabid3'],
            ['name' => 'kabid4'],
            ['name' => 'ks_sma'],
            ['name' => 'ks_smp'],
            ['name' => 'ks_sd'],
            ['name' => 'koor'],
            ['name' => 'admin'],
            ['name' => 'user'],
        ]);
    }
}
