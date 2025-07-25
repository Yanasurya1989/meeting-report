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
                        <td>{{ $m->notulen }}</td>
                        <td>{{ is_array($m->peserta) ? implode(', ', $m->peserta) : $m->peserta }}</td>
                        <td>{{ $m->agenda }}</td>
                        <td>{{ $m->waktu }}</td>
                        <td>
                            @if ($m->capture_image)
                                <img src="{{ asset('meeting_photos/' . $m->capture_image) }}" alt="Capture"
                                    width="100">
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
</body>

</html>
