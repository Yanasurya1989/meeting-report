<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Laporan Meeting</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Form Laporan Meeting</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <script>
            setTimeout(() => {
                document.querySelectorAll('[class*="bg-green-100"], [class*="bg-red-100"]').forEach(el => {
                    el.style.display = 'none';
                });
            }, 3000);
        </script>

        {{-- Form mulai di sini --}}
        <form action="{{ route('meeting.store') }}" method="POST">
            @csrf

            <!-- Notulen -->
            <div class="mb-4">
                <label for="notulen" class="block text-sm font-medium text-gray-700 mb-1">Notulen</label>
                <textarea id="notulen" name="notulen" rows="4" required class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
            </div>

            <!-- Peserta -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Daftar Peserta</label>
                <div class="grid grid-cols-2 gap-2">
                    @php $peserta = ['Ali', 'Budi', 'Citra', 'Dewi', 'Eka']; @endphp
                    @foreach ($peserta as $nama)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="peserta[]" value="{{ $nama }}"
                                class="rounded border-gray-300">
                            <span>{{ $nama }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Kamera (Capture Otomatis) -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Ambil Foto Otomatis</label>
                <div class="flex space-x-4">
                    <video id="video" autoplay playsinline class="w-48 h-36 rounded border"></video>
                    <img id="preview" class="w-48 h-36 rounded border" alt="Hasil Capture">
                </div>
                <canvas id="canvas" class="hidden"></canvas>
                <input type="hidden" name="capture_image" id="capture_image">
            </div>

            <!-- Waktu -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
                <input type="text" id="waktu" name="waktu_rapat" readonly
                    class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 text-gray-800">
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const waktuField = document.getElementById('waktu');
            const now = new Date();

            const localDateTime = now.getFullYear() + "-" +
                String(now.getMonth() + 1).padStart(2, '0') + "-" +
                String(now.getDate()).padStart(2, '0') + " " +
                String(now.getHours()).padStart(2, '0') + ":" +
                String(now.getMinutes()).padStart(2, '0') + ":" +
                String(now.getSeconds()).padStart(2, '0');

            waktuField.value = localDateTime;
        });


        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const photoInput = document.getElementById('capture_image');
        const preview = document.getElementById('preview');

        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
                video.srcObject = stream;

                setTimeout(() => {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    canvas.getContext('2d').drawImage(video, 0, 0);
                    const imageData = canvas.toDataURL('image/png');
                    photoInput.value = imageData;
                    preview.src = imageData;
                    stream.getTracks().forEach(track => track.stop());
                    video.classList.add('opacity-50');
                }, 2000);
            } catch (err) {
                alert('Tidak bisa mengakses kamera.');
                console.error(err);
            }
        }

        window.addEventListener('DOMContentLoaded', startCamera);
    </script>
</body>

</html>
