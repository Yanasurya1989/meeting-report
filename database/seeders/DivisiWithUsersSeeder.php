<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Support\Facades\Hash;

class DivisiWithUsersSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Unit SD' => [
                'Annisa fatwa purnama',
                'Siti Fazri',
                'Febyanti Nur Fitriani',
                'Rise Fathonah',
                'Risna Ayu Siti Solihat',
                'Emma Kiki Maria',
                'Dedi Sopian',
                'Fitriani',
                'Ikhlas Naufal Marijan, S.Pd',
                'Yuni Yulianingsih',
                'Winda Rusmiati Purnama',
                'Amalia Nur Sabbila, S. Hum',
                'Intan Septiaranie Jannatun Naim',
                'Muhammad Said',
                'Lisda Nurhardiyanti',
                'NENG SRI HARDIANTI',
                'Weni Santika',
                'Silvi Noviani',
                'Ilham Nurzaman',
                'Risma Afrianti',
                'Firdausi Nuzula, S.Pd.',
                'Rangga Aditya Pratama',
                'Yasinta Amelia',
                'Sulaeman',
                'Heru Setio Darmaji',
                'Fetty Marwati Sanusi',
                'Hadian Sahidin',
                'Anisa Auliya',
                'Yuli Ratmawati',
                'Ayu Melani Nurjanah',
                'solehudin',
                'Rina Siti Mariam, S.Pd.',
                'Husni Aulia',
                'Syifa Amalia ',
                'Siti Mariah',
                'Enong Yulia',
                'Lia Aulia',
                'Dina Nur Hikmayati',
                'Hilmi Muhamad',
                'Tatan Desrina S.Pd.I',
                'Ida Nuryani',
                'Annisa islami M S.Ag',
                'Tita Komala Dewi',
                'Dilla Marliana Hidayanti',
                'Yulia Risdiana',
                'Tarisa Bintang Maharani',
                'Azalia Ratri Choerunisa',
                'Dini Nur Apriani',
                'Reza Dwi Putra Ramadhan'
            ],
            'Unit SMP' => [
                'Nadia Nuraeni, S.Ak',
                'safarina fatihah',
                'HUSNITA RACHMAH',
                'Murni Sucianti',
                'Ridho Darajat',
                'Rini Rahayu Febrianty',
                'Fahma Muhammad Ramadhan',
                'Hamdan Zulfa',
                'jayinah',
                'Iqbal Hardiyansah',
                'Popy Adilia Khofifah',
                'Irfan Firdaus',
                'Reza Firmansyah',
                'Utami Wulandari, S.Pd',
                'Rahmasari Aisyah Fitri',
                'Rika Siti Fatimah',
                'Mulki Ahmad Fauzi',
                'Dita Amanda Maulani, S. Pd.',
                'Irhamna Pratiwi',
                'Hannani Hamdiyah Inayatillah',
                'Edi Junaedi',
                'Isma Safera',
                'Yunitasari',
                'Nur Ahisnil Fadilah',
                'Nuni Yuniartini',
                'Zalfa Fadilatul Aula',
                'Subhana'
            ],
            'Unit SMA' => [
                'Titin Sumiarti',
                'Nabilah Salma Putri',
                'Moch Maulana Sidik S',
                'Susi Rahmawati',
                'Jeni Aprilia',
                'Asla Zahid Hanifah',
                'Teja Zakiah Darojah',
                'Wihandani',
                'Imas Rini Minarni',
                'Berliana Febiola Agustina',
                'Ai Sri Winarti, S.Pd.',
                'Alda Oktavia, S.Mat.',
                'Nova Herdiana',
                'Fathimah Az-Zahra',
                'Malikussaleh',
                'Nur Rohmah, S.Pd',
                'Abdurrohman Wahid',
                'Dessy Wulandari',
                'Nandang',
                'Hamdan Alawi',
                'Agisna Bilgisthi, S. Pd',
                'Ria Rachmawaty',
                'Lany Silpi Nopia',
                'Mei Ayu Andriani Pgb, S.Hum.'
            ],
            'PKS' => ['Citra', 'Dewi'],
            'Manajemen Level' => ['Eko', 'Fani'],
            'Al-Quran' => ['Gina'],
            'Bahasa Arab' => ['Hasan'],
            'Bahasa Ingris' => ['Indah', 'Joko'],
            'Tim Kesiswaan' => ['Kiki'],
            'Mata Pelajaran' => ['Lina', 'Maman'],
            'KS-BK' => ['Nina'],
            'KS-Kurikulum' => ['Oki'],
            'koord PU' => ['Puspita', 'Qory'],
            'kls internasional' => ['Rian'],
            'KS-Kesiswaan' => ['Sari', 'Tono'],
        ];

        foreach ($data as $divisiName => $users) {
            $divisi = Divisi::firstOrCreate(['nama' => $divisiName]);

            foreach ($users as $userName) {
                // Buat user kalau belum ada
                $user = User::firstOrCreate(
                    ['name' => $userName],
                    [
                        'email' => strtolower(str_replace(' ', '', $userName)) . '@example.com',
                        'password' => Hash::make('password'),
                    ]
                );

                // Hubungkan user ke divisi
                $user->divisis()->syncWithoutDetaching([$divisi->id]);
            }
        }
    }
}
