@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">
        <h2 class="text-xl font-bold mb-4">Rekap Kehadiran Rapat</h2>
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center mb-4 text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg shadow transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 9.75L12 4l9 5.75M4.5 10.5v8.25a.75.75 0 00.75.75h4.5v-4.5a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5v4.5h4.5a.75.75 0 00.75-.75V10.5" />
            </svg>
            Dashboard
        </a>
        <form method="GET" class="flex space-x-4 mb-6">
            <input type="date" name="dari" class="border rounded px-2 py-1" value="{{ request('dari') }}" required>
            <input type="date" name="sampai" class="border rounded px-2 py-1" value="{{ request('sampai') }}" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tampilkan</button>
        </form>
        @if (!empty($rekap))
            <div class="mb-4">
                <a href="{{ route('rekap.smp.export') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    📤 Export Excel
                </a>
            </div>
        @endif

        @if (!empty($rekap))
            <table class="w-full table-auto border border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-3 py-2 text-left">Nama Peserta</th>
                        <th class="border px-3 py-2 text-left">Jumlah Rapat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekap as $nama => $jumlah)
                        <tr>
                            <td class="border px-3 py-1">{{ $nama }}</td>
                            <td class="border px-3 py-1">{{ $jumlah }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif(request()->has('dari'))
            <div class="text-gray-600 mt-4">Tidak ada data peserta dalam rentang tanggal tersebut.</div>
        @endif
    </div>
@endsection
