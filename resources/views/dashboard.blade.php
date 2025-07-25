@extends('layouts.app')

@section('content')
    <div class="p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Dashboard Backend</h2>
            <button onclick="toggleDark()" class="bg-gray-200 dark:bg-gray-700 p-2 rounded text-sm">
                🌗 Toggle Mode
            </button>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card Selamat Datang -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">👋 Selamat Datang</h3>
                <p class="text-sm text-gray-500 dark:text-gray-300 mt-2">Ini adalah tampilan awal dashboard admin.</p>
            </div>

            <!-- Card Daftar Pengguna -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">📋 Daftar Pengguna</h3>
                <table class="w-full mt-3 text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead class="text-gray-500 dark:text-gray-400 border-b dark:border-gray-700">
                        <tr>
                            <th class="py-2">Nama</th>
                            <th>Jabatan</th>
                            <th>Bidang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2">Yusuf</td>
                            <td>Kepala Sekolah</td>
                            <td>SMA</td>
                        </tr>
                        <tr>
                            <td class="py-2">Ani</td>
                            <td>Guru</td>
                            <td>Bidang1</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
