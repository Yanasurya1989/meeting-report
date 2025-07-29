<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'direktur',
            'kabid1',
            'kabid2',
            'kabid3',
            'kabid4',
            'ks_sma',
            'ks_smp',
            'ks_sd',
            'koor',
            'admin',
            'user',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }
    }
}
