<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Laporan Meeting Bidang 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Daftar Meeting Report - Bidang 1</h2>
        {{-- <a href="{{ route('bidang1.create') }}" class="btn btn-primary mb-3">+ Tambah Laporan</a> --}}
        <a href="{{ route('dashboard') }}" class="btn btn-primary mb-3"
            class="inline-flex items-center mb-4 text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg shadow transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 9.75L12 4l9 5.75M4.5 10.5v8.25a.75.75 0 00.75.75h4.5v-4.5a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5v4.5h4.5a.75.75 0 00.75-.75V10.5" />
            </svg>
            Dashboard
        </a>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Notulen</th>
                    <th>Peserta</th>
                    <th>Waktu</th>
                    <th>Gambar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($meetings as $index => $m)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $m->notulen }}</td>
                        <td>{{ is_array($m->peserta) ? implode(', ', $m->peserta) : $m->peserta }}</td>
                        <td>{{ \Carbon\Carbon::parse($m->waktu_rapat)->format('Y-m-d H:i:s') }}</td>
                        <td>
                            @if ($m->capture_image)
                                <img src="{{ asset($m->capture_image) }}" alt="Capture" width="100">
                            @else
                                Tidak ada gambar
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
