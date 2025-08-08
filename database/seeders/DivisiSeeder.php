<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Divisi;

class DivisiSeeder extends Seeder
{
    public function run(): void
    {
        $divisis = [
            'Unit',
            'PKS',
            'Manajemen Level',
            'Al-Quran',
            'Bahasa Arab',
            'Bahasa Ingris',
            'Tim Kesiswaan',
            'Mata Pelajaran',
            'KS-BK',
            'KS-Kurikulum',
            'Koord PU',
            'Kls Internasional',
            'KS-Kesiswaan',
        ];

        foreach ($divisis as $nama) {
            Divisi::create(['nama' => $nama]);
        }
    }
}
