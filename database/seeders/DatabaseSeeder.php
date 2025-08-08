<?php

namespace Database\Seeders;

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

        // Direktur
        User::firstOrCreate([
            'email' => 'hilda.direktur@example.com',
        ], [
            'name' => 'Hilda Putri Juani, S.Pd',
            'password' => bcrypt('hilda12345'),
            'role_id' => Role::where('name', 'direktur')->first()->id,
        ]);

        // Kabid 2
        User::firstOrCreate([
            'email' => 'erni.kabid2@example.com',
        ], [
            'name' => 'Erni Hermiawati',
            'password' => bcrypt('erni12345'),
            'role_id' => Role::where('name', 'kabid2')->first()->id,
        ]);

        // Kabid 3
        User::firstOrCreate([
            'email' => 'aan.kabid3@example.com',
        ], [
            'name' => 'Aan Yulia',
            'password' => bcrypt('aan12345'),
            'role_id' => Role::where('name', 'kabid3')->first()->id,
        ]);

        // Kabid 4
        User::firstOrCreate([
            'email' => 'tia.kabid4@example.com',
        ], [
            'name' => 'Tia Aprilia',
            'password' => bcrypt('tia12345'),
            'role_id' => Role::where('name', 'kabid4')->first()->id,
        ]);

        // KS SD
        User::firstOrCreate([
            'email' => 'dadah.ks_sd@example.com',
        ], [
            'name' => 'Dadah Mujahidah, S.Pd',
            'password' => bcrypt('dadah12345'),
            'role_id' => Role::where('name', 'ks_sd')->first()->id,
        ]);

        // KS SMP
        User::firstOrCreate([
            'email' => 'dindin.ks_smp@example.com',
        ], [
            'name' => 'Dindin Jaenudin, Lc.',
            'password' => bcrypt('dindin12345'),
            'role_id' => Role::where('name', 'ks_smp')->first()->id,
        ]);

        // KS SMA
        User::firstOrCreate([
            'email' => 'hendi.ks_sma@example.com',
        ], [
            'name' => 'Hendi Rochimat',
            'password' => bcrypt('hendi12345'),
            'role_id' => Role::where('name', 'ks_sma')->first()->id,
        ]);
        $this->call(DivisiWithUsersSeeder::class);
    }
}
