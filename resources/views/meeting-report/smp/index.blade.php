<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Meeting Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Daftar Meeting Report</h2>
        <a href="{{ route('dashboard') }}" class="btn btn-primary mb-3">
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
                    <th>Agenda</th>
                    <th>Waktu</th>
                    <th>Gambar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($meetings as $index => $m)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#notulenModal{{ $m->id }}">
                                Lihat Notulen
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="notulenModal{{ $m->id }}" tabindex="-1"
                                aria-labelledby="notulenModalLabel{{ $m->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="notulenModalLabel{{ $m->id }}">Notulen
                                                Rapat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            {!! $m->notulen !!}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ is_array($m->peserta) ? implode(', ', $m->peserta) : $m->peserta }}</td>
                        <td>{{ $m->agenda }}</td>
                        <td>{{ $m->waktu_rapat }}</td>
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
                        <td colspan="6" class="text-center">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
