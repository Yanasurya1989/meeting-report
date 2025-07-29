@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4 text-blue-600">Daftar Laporan Rapat - Bidang Dua</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full table-auto border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Waktu</th>
                    <th class="border px-4 py-2">Notulen</th>
                    <th class="border px-4 py-2">Peserta</th>
                    <th class="border px-4 py-2">Foto</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan as $item)
                    <tr>
                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($item->waktu_rapat)->format('d M Y H:i') }}
                        </td>
                        <td class="border px-4 py-2">{{ $item->notulen }}</td>
                        <td class="border px-4 py-2">
                            @php $peserta = is_string($item->peserta) ? json_decode($item->peserta, true) : $item->peserta; @endphp
                            <ul class="list-disc list-inside">
                                @foreach ($peserta as $p)
                                    <li>{{ $p }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="border px-4 py-2">
                            @if ($item->capture_image)
                                <img src="{{ asset($item->capture_image) }}" alt="Foto" class="w-32 rounded shadow">
                            @else
                                Tidak ada foto
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
