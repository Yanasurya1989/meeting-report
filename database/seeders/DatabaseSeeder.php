<?php

namespace Database\Seeders;

// database/seeders/DatabaseSeeder.php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Jalankan RoleSeeder dulu
        $this->call(RoleSeeder::class);

        // Ambil role admin dari DB
        $adminRole = Role::where('name', 'admin')->first();

        // Buat user admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role_id' => $adminRole->id,
            'password' => Hash::make('password'),
        ]);

        User::firstOrCreate([
            'email' => 'hilda.direktur@example.com',
        ], [
            'name' => 'Hilda Putri Juani',
            'password' => bcrypt('hilda12345'),
            'role_id' => Role::where('name', 'direktur')->first()->id,
        ]);
    }
}
