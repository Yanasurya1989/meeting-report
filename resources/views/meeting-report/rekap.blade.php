@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">
        <h2 class="text-xl font-bold mb-4">Rekap Kehadiran Peserta Meeting</h2>

        <form method="GET" class="flex space-x-4 mb-6">
            <input type="date" name="dari" class="border rounded px-2 py-1" value="{{ request('dari') }}" required>
            <input type="date" name="sampai" class="border rounded px-2 py-1" value="{{ request('sampai') }}" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tampilkan</button>
        </form>

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
