@extends('layouts.app')

@section('content')
    <div class="p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Dashboard Backend</h2>
            <button onclick="toggleDark()" class="bg-gray-200 dark:bg-gray-700 p-2 rounded text-sm">
                🌗 Toggle Mode
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card Selamat Datang -->
            @php
                $user = Auth::user();
            @endphp

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">👋 Selamat Datang, {{ $user->name }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-300 mt-2">
                    @if ($user->role->name === 'direktur')
                        Anda login sebagai Direktur. Anda dapat melihat seluruh rekap rapat semua divisi.
                    @else
                        Anda login sebagai {{ ucfirst($user->role->name) }} di bidang {{ $user->bidang ?? '-' }}.
                        Berikut ini adalah rekap rapat bidang Anda.
                    @endif
                </p>
            </div>

            <!-- Card Daftar Pengguna -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div x-data="{ showAll: false }" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">📋 Daftar Pengguna</h3>

                    <table class="table-auto w-full text-left">
                        <thead>
                            <tr>
                                <th class="font-semibold">Nama</th>
                                <th class="font-semibold"> </th>
                                <th class="font-semibold">Bidang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr x-show="showAll || {{ $index }} < 3" class="border-t">
                                    <td>{{ $user->name }}</td>
                                    <td> </td>
                                    {{-- <td>{{ $user->role->id ?? '-' }}</td> --}}
                                    <td>{{ $user->bidang ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if (count($users) > 2)
                        <div class="text-center mt-2">
                            <button @click="showAll = !showAll"
                                class="text-blue-500 hover:underline text-sm flex items-center justify-center mx-auto">
                                <template x-if="!showAll">
                                    <span>🔽 Tampilkan Semua</span>
                                </template>
                                <template x-if="showAll">
                                    <span>🔼 Sembunyikan</span>
                                </template>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card: Loop untuk setiap divisi -->
            @php
                $user = Auth::user();
                $isDirektur = $user->role->name === 'direktur';
                $userBidang = strtolower(str_replace(' ', '-', $user->bidang));
            @endphp

            @foreach ($meetings as $divisi => $data)
                @if ($isDirektur || $divisi === $user->bidang)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                📝 5 Rapat Terbaru - {{ ucfirst(str_replace('-', ' ', $divisi)) }}
                            </h3>
                            <a href="{{ $divisi === 'yayasan'
                                ? route('meeting.index')
                                : ($divisi === 'bidang-satu'
                                    ? route('meeting.bidang-satu.index')
                                    : ($divisi === 'bidang-dua'
                                        ? route('meeting.bidang-dua.index')
                                        : ($divisi === 'bidang-tiga'
                                            ? route('meeting.bidang-tiga.index')
                                            : ($divisi === 'bidang-empat'
                                                ? route('meeting.bidang-empat.index')
                                                : ($divisi === 'ks-sd'
                                                    ? route('meeting.ks-sd.index')
                                                    : ($divisi === 'ks-smp'
                                                        ? route('meeting.ks-smp.index')
                                                        : ($divisi === 'ks-sma'
                                                            ? route('sma.index')
                                                            : '#'))))))) }}"
                                class="text-blue-600 dark:text-blue-400 text-sm hover:underline">
                                Lihat Semua
                            </a>
                        </div>
                        <ul class="list-disc list-inside text-sm text-gray-700 dark:text-gray-300 space-y-1">
                            @forelse ($data as $meeting)
                                <li>
                                    <span class="font-semibold">
                                        {{ $meeting->notulen }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        ({{ \Carbon\Carbon::parse($meeting->waktu_rapat)->translatedFormat('d M Y') }})
                                    </span>
                                </li>
                            @empty
                                <li class="text-gray-500 italic">Belum ada data rapat.</li>
                            @endforelse
                        </ul>

                    </div>
                @endif
            @endforeach

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function toggleDark() {
            document.documentElement.classList.toggle('dark');
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        }

        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
@endsection
