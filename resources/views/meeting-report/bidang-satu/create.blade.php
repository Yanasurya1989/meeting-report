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

        <form action="{{ route('all-sub-divisi-store') }}" method="POST">
            @csrf

            <!-- Notulen -->
            <div class="mb-4">
                <label for="notulen" class="block text-sm font-medium text-gray-700 mb-1">Notulen</label>
                <textarea id="notulen" name="notulen" rows="4" required class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
            </div>

            <!-- Pilih Divisi -->
            <div class="mb-4">
                <label for="divisi" class="block text-sm font-medium text-gray-700 mb-1">Pilih Divisi</label>
                <select id="divisi" name="divisi" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">-- Pilih Divisi --</option>
                </select>
            </div>

            <!-- Pilih Sub Divisi -->
            <div class="mb-4" id="subDivisiWrapper" style="display:none;">
                <label for="sub_divisi" class="block text-sm font-medium text-gray-700 mb-1">Pilih Sub Divisi</label>
                <select id="sub_divisi" name="sub_divisi" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">-- Pilih Sub Divisi --</option>
                </select>
            </div>

            <!-- Peserta -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Daftar Peserta</label>
                <label class="flex items-center space-x-2 mb-2">
                    <input type="checkbox" id="checkAll" class="rounded border-gray-300">
                    <span><strong>Centang Semua Peserta</strong></span>
                </label>
                <div id="pesertaContainer" class="grid grid-cols-2 gap-2">
                    <p class="text-gray-500">Silakan pilih divisi atau sub divisi terlebih dahulu.</p>
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

                <button type="button" id="captureAgain" class="mt-2 bg-gray-500 text-white px-3 py-1 rounded">
                    Ambil Ulang Foto
                </button>

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
        // Data Divisi, Sub Divisi, Peserta
        const dataDivisi = {
            "Yayasan": {
                peserta: ["Hilda", "Sati", "Erni", "Aan", "Thia", "Dadah", "Dindin", "Hendi"]
            },
            "Bidang 1": {
                subDivisi: {
                    "Koord PU": ["Andi", "Budi", "Citra"],
                    "Kls International": ["Rina", "Susi", "Bayu"]
                }
            },
            "Bidang 2": {
                subDivisi: {
                    "Rapat dg tim Sarpras": ["Sari", "Agus", "Fikri"],
                    "Rapat dg tim UUS": ["Ayu", "Bambang", "Dewi"],
                    "Rapat dg tim AJS": ["Lina", "Tono", "Rizki"],
                    "Rapat dg tim CS": ["Vina", "Rudi", "Nanda"],
                    "Koordinasi dg tim BSP": ["Putri", "Adit", "Wulan"],
                    "Koordinasi dg tim QFC": ["Samsul", "Gita", "Rama"]
                }
            },
            "Bidang 3": {
                subDivisi: {
                    "PPDB": ["Eka", "Fina", "Sandi"],
                    "Medsos Siswa": ["Heri", "Lusi", "Dani"],
                    "Medsos Sekolah": ["Yani", "Iwan", "Mira"]
                }
            },
            "Bidang 4": {
                peserta: ["Anton", "Bella", "Caca", "Dono", "Evi"]
            },
            "SD": {
                subDivisi: {
                    "Rapat KS-Wakasek": ["Wahyu", "Nina", "Beni"],
                    "Rapat Managemen": ["Siti", "Fajar", "Tari"],
                    "Rapat KS-Koord. Program Unggulan": ["Udin", "Cici", "Toto"],
                    "Rapat KS-Korjen": ["Vivi", "Heri", "Zaki"],
                    "Rapat KS/Wakasek-BK": ["Bunga", "Rino", "Galih"],
                    "Rapat KS/Wakasek-Koord.Wusho": ["Gina", "Hana", "Rio"],
                    "Rapat KS/Wakasek-Koord.Kelulusan": ["Hani", "Jaka", "Miko"],
                    "Rapat Tim Bahasa Arab": ["Zahra", "Fahri", "Lutfi"],
                    "Rapat Tim Bahasa Inggris": ["Sari", "Andra", "Bima"],
                    "Rapat Tim AQ": ["Yoga", "Hilda", "Putra"],
                    "Rapat Tim MTK": ["Rini", "Edo", "Lala"],
                    "Rapat Tim PAI": ["Tina", "Raka", "Deni"],
                    "Rapat Umum": ["Oka", "Mila", "Faisal"]
                }
            },
            "SMP": {
                subDivisi: {
                    "Rapat Unit": ["Fani", "Seno", "Tari"],
                    "Rapat PKS": ["Indra", "Putri", "Bayu"],
                    "Rapat Manajemen Level": ["Ari", "Nita", "Gilang"],
                    "Rapat Al-Quran": ["Umar", "Hana", "Fikri"],
                    "Rapat Bahasa Arab": ["Zaki", "Sari", "Budi"],
                    "Rapat Bahasa Inggris": ["Lina", "Eko", "Rina"],
                    "Rapat Tim Kesiswaan": ["Rizki", "Mira", "Tono"],
                    "Rapat Mata Pelajaran": ["Adi", "Vivi", "Bagas"],
                    "Rapat KS-BK": ["Dewi", "Candra", "Wawan"],
                    "Rapat KS-Kurikulum": ["Yudi", "Fitri", "Andi"],
                    "Rapat KS-Kesiswaan": ["Fani", "Tata", "Herman"]
                }
            },
            "SMA": {
                subDivisi: {
                    "PKS Kurikulum": ["Rama", "Fahmi", "Nina"],
                    "PKS Kesiswaan": ["Bagus", "Anisa", "Tio"],
                    "Koordinator Program Unggulan": ["Wulan", "Ardi", "Sari"],
                    "Tim literasi": ["Rudi", "Tika", "Gilang"],
                    "Tim UTBK": ["Evi", "Heri", "Sandi"],
                    "Tim Evakuasi": ["Bayu", "Lina", "Rama"],
                    "Tim pengembangan kurikulum": ["Vina", "Hadi", "Putra"],
                    "Tim sarana": ["Reno", "Gita", "Wawan"],
                    "PJ organisasi": ["Sinta", "Eko", "Dewi"],
                    "PJ ibadah": ["Yusuf", "Hana", "Andri"],
                    "PJ media": ["Zahra", "Fani", "Rendi"],
                    "PJ lomba": ["Dina", "Adi", "Putri"],
                    "PJ ekskul": ["Rizki", "Bela", "Hendra"],
                    "BK": ["Faisal", "Mira", "Gilang"]
                }
            }
        };

        const divisiSelect = document.getElementById('divisi');
        const subDivisiWrapper = document.getElementById('subDivisiWrapper');
        const subDivisiSelect = document.getElementById('sub_divisi');
        const pesertaContainer = document.getElementById('pesertaContainer');

        // Load divisi
        Object.keys(dataDivisi).forEach(div => {
            const opt = document.createElement('option');
            opt.value = div;
            opt.textContent = div;
            divisiSelect.appendChild(opt);
        });

        // Handle divisi change
        divisiSelect.addEventListener('change', function() {
            const selected = this.value;
            pesertaContainer.innerHTML = '';

            if (!selected) {
                subDivisiWrapper.style.display = 'none';
                pesertaContainer.innerHTML =
                    '<p class="text-gray-500">Silakan pilih divisi atau sub divisi terlebih dahulu.</p>';
                return;
            }

            const data = dataDivisi[selected];
            if (data.peserta) {
                subDivisiWrapper.style.display = 'none';
                renderPeserta(data.peserta);
            } else if (data.subDivisi) {
                subDivisiWrapper.style.display = 'block';
                subDivisiSelect.innerHTML = '<option value="">-- Pilih Sub Divisi --</option>';
                Object.keys(data.subDivisi).forEach(sub => {
                    const opt = document.createElement('option');
                    opt.value = sub;
                    opt.textContent = sub;
                    subDivisiSelect.appendChild(opt);
                });
                pesertaContainer.innerHTML =
                    '<p class="text-gray-500">Silakan pilih sub divisi terlebih dahulu.</p>';
            }
        });

        // Handle sub divisi change
        subDivisiSelect.addEventListener('change', function() {
            const selectedDivisi = divisiSelect.value;
            const selectedSub = this.value;
            if (!selectedSub) {
                pesertaContainer.innerHTML =
                    '<p class="text-gray-500">Silakan pilih sub divisi terlebih dahulu.</p>';
                return;
            }
            renderPeserta(dataDivisi[selectedDivisi].subDivisi[selectedSub]);
        });

        // Render peserta
        function renderPeserta(list) {
            pesertaContainer.innerHTML = '';
            list.forEach(nama => {
                const label = document.createElement('label');
                label.className = 'flex items-center space-x-2';
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'peserta[]';
                checkbox.value = nama;
                checkbox.className = 'rounded border-gray-300';
                const span = document.createElement('span');
                span.textContent = nama;
                label.appendChild(checkbox);
                label.appendChild(span);
                pesertaContainer.appendChild(label);
            });
        }

        // Check all
        document.getElementById('checkAll').addEventListener('change', function() {
            document.querySelectorAll('#pesertaContainer input[type="checkbox"]').forEach(cb => cb.checked = this
                .checked);
        });

        // Set waktu otomatis
        const waktuField = document.getElementById('waktu');
        const now = new Date();
        waktuField.value = now.getFullYear() + "-" +
            String(now.getMonth() + 1).padStart(2, '0') + "-" +
            String(now.getDate()).padStart(2, '0') + " " +
            String(now.getHours()).padStart(2, '0') + ":" +
            String(now.getMinutes()).padStart(2, '0') + ":" +
            String(now.getSeconds()).padStart(2, '0');
    </script>
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
                }, 2000);

            } catch (err) {
                alert('Tidak bisa mengakses kamera.');
                console.error(err);
            }
        }

        window.addEventListener('DOMContentLoaded', startCamera);
    </script>
    <script>
        document.getElementById('captureAgain').addEventListener('click', () => {
            canvas.getContext('2d').drawImage(video, 0, 0);
            const imageData = canvas.toDataURL('image/png');
            photoInput.value = imageData;
            preview.src = imageData;
        });
    </script>
</body>

</html>
