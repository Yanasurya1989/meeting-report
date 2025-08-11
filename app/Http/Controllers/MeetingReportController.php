<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Models\MeetingReport;
use App\Models\MeetingKoordPU;
use App\Models\MeetingReportSD;
use App\Exports\BidangDuaExport;
use App\Models\MeetingReportSma;
use App\Models\MeetingReportSmp;
use App\Exports\BidangTigaExport;
use App\Exports\BidangEmpatExport;
use App\Models\MeetingReportBidang1;
use App\Models\MeetingReportBidang2;
use App\Models\MeetingReportBidang3;
use App\Models\MeetingReportBidang4;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MeetingReportSdExport;
use App\Exports\RekapBidangSatuExport;
use App\Exports\MeetingReportSmaExport;
use App\Exports\MeetingReportSmpExport;
use App\Models\MeetingKlsInternational;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MeetingReportController extends Controller
{
    public function indexSubdivisi()
    {
        // Data lengkap divisi, sub divisi, dan nama-nama peserta
        $data = [
            'Yayasan' => [
                'subdivisi' => [],
                'peserta' => ['Hilda', 'Sati', 'Erni', 'Aan', 'Thia', 'Dadah', 'Dindin', 'Hendi']
            ],

            'Bidang 1' => [
                'subdivisi' => [
                    'Koord PU' => ['Budi', 'Susi', 'Tono'],
                    'Kelas International' => ['Rani', 'Rudi', 'Dewi']
                ]
            ],

            'Bidang 2' => [
                'subdivisi' => [
                    'Rapat dg tim Sarpras' => ['Andi', 'Bambang', 'Citra'],
                    'Rapat dg tim UUS' => ['Dian', 'Eka', 'Fajar'],
                    'Rapat dg tim AJS' => ['Gina', 'Heri', 'Intan'],
                    'Rapat dg tim CS' => ['Joko', 'Kiki', 'Lina'],
                    'Koordinasi dg tim BSP' => ['Made', 'Nina', 'Oki'],
                    'Koordinasi dg tim QFC' => ['Putri', 'Qori', 'Rian'],
                ]
            ],

            'Bidang 3' => [
                'subdivisi' => [
                    'PPDB' => ['Dumy1', 'Dumy2', 'Dumy3'],
                    'Medsos Siswa' => ['Dumy4', 'Dumy5', 'Dumy6'],
                    'Medsos Sekolah' => ['Dumy7', 'Dumy8', 'Dumy9']
                ]
            ],

            'Bidang 4' => [
                'subdivisi' => [],
                'peserta' => ['Alpha', 'Bravo', 'Charlie', 'Delta']
            ],

            'SD' => [
                'subdivisi' => [
                    'Rapat KS-Wakasek' => ['Satu', 'Dua', 'Tiga'],
                    'Rapat Managemen' => ['Empat', 'Lima', 'Enam'],
                    'Rapat KS-Koord. Program Unggulan' => ['Tujuh', 'Delapan', 'Sembilan'],
                    'Rapat KS-Korjen' => ['Sepuluh', 'Sebelas', 'Dua Belas'],
                    'Rapat KS/Wakasek-BK' => ['Tiga Belas', 'Empat Belas'],
                    'Rapat KS/Wakasek-Koord.Wusho' => ['Lima Belas', 'Enam Belas'],
                    'Rapat KS/Wakasek-Koord.Kelulusan' => ['Tujuh Belas', 'Delapan Belas'],
                    'Rapat Tim Bahasa Arab' => ['Sembilan Belas', 'Dua Puluh'],
                    'Rapat Tim Bahasa Inggris' => ['Dua Puluh Satu', 'Dua Puluh Dua'],
                    'Rapat Tim AQ' => ['Dua Puluh Tiga', 'Dua Puluh Empat'],
                    'Rapat Tim MTK' => ['Dua Puluh Lima', 'Dua Puluh Enam'],
                    'Rapat Tim PAI' => ['Dua Puluh Tujuh', 'Dua Puluh Delapan'],
                    'Rapat Umum' => ['Dua Puluh Sembilan', 'Tiga Puluh']
                ]
            ],

            'SMP' => [
                'subdivisi' => [
                    'Rapat Unit' => ['A1', 'A2', 'A3'],
                    'Rapat PKS' => ['B1', 'B2', 'B3'],
                    'Rapat Manajemen Level' => ['C1', 'C2', 'C3'],
                    'Rapat Al-Quran' => ['D1', 'D2', 'D3'],
                    'Rapat Bahasa Arab' => ['E1', 'E2', 'E3'],
                    'Rapat Bahasa Inggris' => ['F1', 'F2', 'F3'],
                    'Rapat Tim Kesiswaan' => ['G1', 'G2', 'G3'],
                    'Rapat Mata Pelajaran' => ['H1', 'H2', 'H3'],
                    'Rapat KS-BK' => ['I1', 'I2', 'I3'],
                    'Rapat KS-Kurikulum' => ['J1', 'J2', 'J3'],
                    'Rapat KS-Kesiswaan' => ['K1', 'K2', 'K3']
                ]
            ],

            'SMA' => [
                'subdivisi' => [
                    'PKS Kurikulum' => ['AA', 'BB', 'CC'],
                    'PKS Kesiswaan' => ['DD', 'EE', 'FF'],
                    'Koordinator Program Unggulan' => ['GG', 'HH', 'II'],
                    'Tim Literasi' => ['JJ', 'KK', 'LL'],
                    'Tim UTBK' => ['MM', 'NN', 'OO'],
                    'Tim Evakuasi' => ['PP', 'QQ', 'RR'],
                    'Tim Pengembangan Kurikulum' => ['SS', 'TT', 'UU'],
                    'Tim Sarana' => ['VV', 'WW', 'XX'],
                    'PJ Organisasi' => ['YY', 'ZZ', 'AAA'],
                    'PJ Ibadah' => ['BBB', 'CCC', 'DDD'],
                    'PJ Media' => ['EEE', 'FFF', 'GGG'],
                    'PJ Lomba' => ['HHH', 'III', 'JJJ'],
                    'PJ Ekskul' => ['KKK', 'LLL', 'MMM'],
                    'BK' => ['NNN', 'OOO', 'PPP']
                ]
            ]
        ];

        return view('meeting.index-subdivisi', compact('data'));
    }

    public function allSubDivisiStoreBalikinIniKloBawahGabisa(Request $request)
    {
        $request->validate([
            'notulen'       => 'required|string',
            'peserta'       => 'required|array',
            'capture_image' => 'required|string',
            'waktu_rapat'   => 'required|date',
            'sub_divisi'    => 'required|string'
        ]);

        $data = [
            'notulen'       => $request->notulen,
            'peserta'       => json_encode($request->peserta),
            'capture_image' => $request->capture_image,
            'waktu_rapat'   => $request->waktu_rapat,
        ];

        $divisiModelMap = [
            'pks'               => \App\Models\MeetingPks::class,
            'manajemen level'   => \App\Models\MeetingManajemenLevel::class,
            'al-quran'          => \App\Models\MeetingAlQuran::class,
            'bahasa arab'       => \App\Models\MeetingBahasaArab::class,
            'bahasa inggris'    => \App\Models\MeetingBahasaIngris::class,
            'tim kesiswaan'     => \App\Models\MeetingTimKesiswaan::class,
            'mata pelajaran'    => \App\Models\MeetingMataPelajaran::class,
            'ks-bk'             => \App\Models\MeetingKsBk::class,
            'ks-kurikulum'      => \App\Models\MeetingKsKurikulum::class,
            'koord pu'          => \App\Models\MeetingKoordPU::class,
            'kls internasional' => \App\Models\MeetingKlsInternational::class,
            'ks-kesiswaan'      => \App\Models\MeetingKsKesiswaan::class,
            // kalau ada model untuk 'unit', tambahkan di sini:
            // 'unit' => \App\Models\MeetingUnit::class,
        ];

        // --- Normalisasi / buat kandidat key ---
        $raw = $request->sub_divisi;
        $normalized = strtolower(trim($raw));
        // hapus prefix seperti "rapat " atau "rapat " (case-insensitive)
        $normalized = preg_replace('/^rapat\s+/i', '', $normalized);
        $normalized = preg_replace('/\s+/', ' ', $normalized); // collapse spaces

        $candidates = [
            $normalized,                        // ex: "ks-kurikulum" or "manajemen level"
            str_replace(' ', '-', $normalized), // "manajemen-level"
            str_replace('-', ' ', $normalized), // "ks kurikulum"
            str_replace(' ', '', $normalized),  // "kskurikulum"
        ];

        $foundKey = null;
        foreach ($candidates as $cand) {
            if (array_key_exists($cand, $divisiModelMap)) {
                $foundKey = $cand;
                break;
            }
        }

        if (!$foundKey) {
            // log untuk debugging lokal
            Log::info('SubDivisi tidak dikenali', [
                'raw' => $raw,
                'normalized' => $normalized,
                'candidates' => $candidates
            ]);

            return back()
                ->withInput()
                ->with('error', 'Sub divisi tidak dikenali: "' . $raw . '". Dicoba key: ' . implode(', ', $candidates));
        }

        try {
            $modelClass = $divisiModelMap[$foundKey];
            $modelClass::create($data);
            return back()->with('success', 'Laporan berhasil disimpan.');
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan meeting', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function allSubDivisiStore(Request $request)
    {
        $request->validate([
            'notulen'       => 'required|string',
            'peserta'       => 'required|array',
            'capture_image' => 'required|string',
            'waktu_rapat'   => 'required|date',
            // sub_divisi tidak wajib, salah satu dari divisi atau sub_divisi harus ada
        ]);

        // Ambil nama yang akan dipakai untuk mapping
        $raw = $request->sub_divisi ?: $request->divisi; // pakai sub_divisi jika ada, kalau tidak pakai divisi
        $normalized = strtolower(trim($raw));
        $normalized = preg_replace('/^rapat\s+/i', '', $normalized);
        $normalized = preg_replace('/\s+/', ' ', $normalized);

        $candidates = [
            $normalized,
            str_replace(' ', '-', $normalized),
            str_replace('-', ' ', $normalized),
            str_replace(' ', '', $normalized),
        ];

        $divisiModelMap = [
            // sub divisi
            'pks'               => \App\Models\MeetingPks::class,
            'manajemen level'   => \App\Models\MeetingManajemenLevel::class,
            'al-quran'          => \App\Models\MeetingAlQuran::class,
            'bahasa arab'       => \App\Models\MeetingBahasaArab::class,
            'bahasa inggris'    => \App\Models\MeetingBahasaIngris::class,
            'tim kesiswaan'     => \App\Models\MeetingTimKesiswaan::class,
            'mata pelajaran'    => \App\Models\MeetingMataPelajaran::class,
            'ks-bk'             => \App\Models\MeetingKsBk::class,
            'ks-kurikulum'      => \App\Models\MeetingKsKurikulum::class,
            'koord pu'          => \App\Models\MeetingKoordPU::class,
            'kls internasional' => \App\Models\MeetingKlsInternational::class,
            'ks-kesiswaan'      => \App\Models\MeetingKsKesiswaan::class,

            // langsung divisi
            'yayasan'           => \App\Models\MeetingReport::class,
            'bidang 4'          => \App\Models\MeetingReportBidang4::class,
        ];

        $foundKey = null;
        foreach ($candidates as $cand) {
            if (array_key_exists($cand, $divisiModelMap)) {
                $foundKey = $cand;
                break;
            }
        }

        if (!$foundKey) {
            return back()
                ->withInput()
                ->with('error', 'Divisi/Sub divisi tidak dikenali: "' . $raw . '"');
        }

        $data = [
            'notulen'       => $request->notulen,
            'peserta'       => json_encode($request->peserta),
            'capture_image' => $request->capture_image,
            'waktu_rapat'   => $request->waktu_rapat,
        ];

        try {
            $modelClass = $divisiModelMap[$foundKey];
            $modelClass::create($data);
            return back()->with('success', 'Laporan berhasil disimpan.');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function getUsersByDivisi($id)
    {
        $divisi = Divisi::findOrFail($id);
        $users = $divisi->users()->pluck('name', 'id'); // ambil nama & id user

        return response()->json($users);
    }

    public function indexByDivisi($divisi)
    {
        switch ($divisi) {
            case 'yayasan':
                return redirect()->route('meeting.index');
            case 'bidang-satu':
                return redirect()->route('meeting.bidang-satu.index');
            case 'bidang-dua':
                return redirect()->route('meeting.bidang-dua.index');
            default:
                abort(404); // Atau redirect dengan pesan error
        }
    }

    // method yayasan start
    public function index()
    {
        $meetings = MeetingReport::orderBy('created_at', 'desc')->get();
        return view('meeting-report.index', compact('meetings'));
    }

    public function rekap(Request $request)
    {
        $rekap = [];

        if ($request->filled(['dari', 'sampai'])) {
            $dari = Carbon::parse($request->dari)->startOfDay();
            $sampai = Carbon::parse($request->sampai)->endOfDay();

            $laporan = MeetingReport::whereBetween('waktu_rapat', [$dari, $sampai])->get();

            foreach ($laporan as $item) {
                $pesertaArray = is_string($item->peserta) ? json_decode($item->peserta, true) : $item->peserta;

                foreach ($pesertaArray as $nama) {
                    if (!isset($rekap[$nama])) {
                        $rekap[$nama] = 0;
                    }
                    $rekap[$nama]++;
                }
            }

            // Tambahkan baris ini agar bisa diexport ke Excel
            session(['rekap' => $rekap]);
        }

        return view('meeting-report.rekap', compact('rekap'));
    }

    public function create()
    {
        return view('meeting-report.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'notulen' => 'required',
                'peserta' => 'nullable|array',
                'peserta.*' => 'string',
                'capture_image' => 'required',
            ]);

            // Simpan gambar ke folder public/meeting_photos
            $imageName = time() . '.png';
            $imagePath = public_path('meeting_photos/' . $imageName);
            file_put_contents($imagePath, file_get_contents($request->capture_image));

            MeetingReport::create([
                'notulen' => $request->notulen,
                'peserta' => json_encode($request->peserta),
                'waktu_rapat' => now(),
                'capture_image' => 'meeting_photos/' . $imageName,
                'divisi' => 'yayasan',
            ]);

            return redirect()->back()->with('success', 'Data meeting berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data meeting: ' . $e->getMessage());
        }
    }

    // method yayasan end

    // bidang satu start
    public function bidang_satu_index()
    {
        $meetings = MeetingReportBidang1::all();
        return view('meeting-report.bidang-satu.index', compact('meetings'));
    }

    public function bidang_satu_create()
    {
        $divisis = Divisi::all();
        return view('meeting-report.bidang-satu.create', compact('divisis'));
    }

    public function bidang_satu_store(Request $request)
    {
        try {
            $request->validate([
                'notulen' => 'required',
                'peserta' => 'nullable|array',
                'peserta.*' => 'string',
                'capture_image' => 'required',
            ]);

            $imageName = time() . '_b1.png';
            $imagePath = public_path('meeting_photos/' . $imageName);
            file_put_contents($imagePath, file_get_contents($request->capture_image));

            MeetingReportBidang1::create([
                'notulen' => $request->notulen,
                'peserta' => json_encode($request->peserta),
                'waktu_rapat' => now(),
                'capture_image' => 'meeting_photos/' . $imageName,

            ]);

            return redirect()->back()->with('success', 'Data Bidang 1 berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data Bidang 1: ' . $e->getMessage());
        }
    }

    public function rekapBidangSatu(Request $request)
    {
        $rekap = [];

        if ($request->filled(['dari', 'sampai'])) {
            $dari = Carbon::parse($request->dari)->startOfDay();
            $sampai = Carbon::parse($request->sampai)->endOfDay();

            $laporan = MeetingReportBidang1::whereBetween('waktu_rapat', [$dari, $sampai])->get();

            foreach ($laporan as $item) {
                $pesertaArray = is_string($item->peserta) ? json_decode($item->peserta, true) : $item->peserta;

                foreach ($pesertaArray as $nama) {
                    if (!isset($rekap[$nama])) {
                        $rekap[$nama] = 0;
                    }
                    $rekap[$nama]++;
                }
            }

            session(['rekapBidangSatu' => $rekap]);
        }

        return view('meeting-report.bidang-satu.rekap', compact('rekap'));
    }

    public function exportBidangSatu()
    {
        $rekap = session('rekapBidangSatu', []);

        return Excel::download(new RekapBidangSatuExport($rekap), 'rekap-bidang-satu.xlsx');
    }


    // bidang satu end

    // bidang dua start
    public function bidang_dua_create()
    {
        return view('meeting-report.bidang-dua.create');
    }

    public function bidang_dua_store(Request $request)
    {
        try {
            $request->validate([
                'notulen' => 'required',
                'peserta' => 'nullable|array',
                'peserta.*' => 'string',
                'capture_image' => 'required',
            ]);

            $imageName = time() . '_b2.png';
            $imagePath = public_path('meeting_photos/' . $imageName);
            file_put_contents($imagePath, file_get_contents($request->capture_image));

            MeetingReportBidang2::create([
                'notulen' => $request->notulen,
                'peserta' => json_encode($request->peserta),
                'waktu_rapat' => now(),
                'capture_image' => 'meeting_photos/' . $imageName,

            ]);

            return redirect()->back()->with('success', 'Data Bidang 2 berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data Bidang 2: ' . $e->getMessage());
        }
    }

    public function indexBidangDua()
    {
        $meetings = MeetingReportBidang2::latest()->get();

        return view('meeting-report.bidang-dua.index', compact('meetings'));
    }

    public function exportBidangDua()
    {
        $rekap = session('rekap_bidang_dua', []);

        if (empty($rekap)) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diexport.');
        }

        return Excel::download(new BidangDuaExport($rekap), 'rekap_bidang_dua.xlsx');
    }

    public function rekapBidangDua(Request $request)
    {
        $rekap = [];

        if ($request->filled(['dari', 'sampai'])) {
            $dari = Carbon::parse($request->dari)->startOfDay();
            $sampai = Carbon::parse($request->sampai)->endOfDay();

            $laporan = MeetingReportBidang2::whereBetween('waktu_rapat', [$dari, $sampai])->get();

            foreach ($laporan as $item) {
                $pesertaArray = is_string($item->peserta) ? json_decode($item->peserta, true) : $item->peserta;

                if (is_array($pesertaArray)) {
                    foreach ($pesertaArray as $nama) {
                        if (!isset($rekap[$nama])) {
                            $rekap[$nama] = 0;
                        }
                        $rekap[$nama]++;
                    }
                }
            }

            session(['rekap_bidang_dua' => $rekap]);
        }

        return view('meeting-report.bidang-dua.rekap', compact('rekap'));
    }

    // bidang dua end

    // bidang tiga start
    public function bidang_tiga_create()
    {
        return view('meeting-report.bidang-tiga.create');
    }

    public function indexBidangTiga()
    {
        $meetings = MeetingReportBidang3::latest()->get();
        return view('meeting-report.bidang-tiga.index', compact('meetings'));
    }

    public function storeBidangTiga(Request $request)
    {
        try {
            $request->validate([
                'notulen' => 'required',
                'peserta' => 'nullable|array',
                'peserta.*' => 'string',
                'capture_image' => 'required|string',
                'waktu_rapat' => 'required|date',
            ]);

            $imageName = time() . '.png';
            $imagePath = public_path('meeting_photos/' . $imageName);
            file_put_contents($imagePath, file_get_contents($request->capture_image));

            MeetingReportBidang3::create([
                'notulen' => $request->notulen,
                'peserta' => $request->peserta,
                'capture_image' => 'meeting_photos/' . $imageName,
                'waktu_rapat' => $request->waktu_rapat,
            ]);

            return redirect()->back()->with('success', 'Laporan Bidang 3 berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function rekapBidangTiga(Request $request)
    {
        $rekap = [];

        if ($request->filled(['dari', 'sampai'])) {
            $dari = Carbon::parse($request->dari)->startOfDay();
            $sampai = Carbon::parse($request->sampai)->endOfDay();

            $laporan = MeetingReportBidang3::whereBetween('waktu_rapat', [$dari, $sampai])->get();

            foreach ($laporan as $item) {
                $pesertaArray = is_string($item->peserta) ? json_decode($item->peserta, true) : $item->peserta;

                if (is_array($pesertaArray)) {
                    foreach ($pesertaArray as $nama) {
                        if (!isset($rekap[$nama])) {
                            $rekap[$nama] = 0;
                        }
                        $rekap[$nama]++;
                    }
                }
            }

            session(['rekap_bidang_tiga' => $rekap]);
        }

        return view('meeting-report.bidang-tiga.rekap', compact('rekap'));
    }

    public function exportBidangTiga()
    {
        $rekap = session('rekap_bidang_tiga', []);

        if (empty($rekap)) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diexport.');
        }

        return Excel::download(new BidangTigaExport($rekap), 'rekap_bidang_tiga.xlsx');
    }
    // bidang tiga end

    // bidang empat start
    public function bidang_empat_create()
    {
        return view('meeting-report.bidang-empat.create');
    }

    public function indexBidangEmpat()
    {
        $meetings = MeetingReportBidang4::latest()->get();
        return view('meeting-report.bidang-empat.index', compact('meetings'));
    }

    public function storeBidangEmpat(Request $request)
    {
        try {
            $request->validate([
                'notulen' => 'required',
                'peserta' => 'nullable|array',
                'peserta.*' => 'string',
                'capture_image' => 'required|string',
                'waktu_rapat' => 'required|date',
            ]);

            $imageName = time() . '.png';
            $imagePath = public_path('meeting_photos/' . $imageName);
            file_put_contents($imagePath, file_get_contents($request->capture_image));

            MeetingReportBidang4::create([
                'notulen' => $request->notulen,
                'peserta' => $request->peserta,
                'capture_image' => 'meeting_photos/' . $imageName,
                'waktu_rapat' => $request->waktu_rapat,
            ]);

            return redirect()->back()->with('success', 'Laporan Bidang 4 berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function rekapBidangEmpat(Request $request)
    {
        $rekap = [];

        if ($request->filled(['dari', 'sampai'])) {
            $dari = Carbon::parse($request->dari)->startOfDay();
            $sampai = Carbon::parse($request->sampai)->endOfDay();

            $laporan = MeetingReportBidang4::whereBetween('waktu_rapat', [$dari, $sampai])->get();

            foreach ($laporan as $item) {
                $pesertaArray = is_string($item->peserta) ? json_decode($item->peserta, true) : $item->peserta;

                if (is_array($pesertaArray)) {
                    foreach ($pesertaArray as $nama) {
                        if (!isset($rekap[$nama])) {
                            $rekap[$nama] = 0;
                        }
                        $rekap[$nama]++;
                    }
                }
            }

            session(['rekap_bidang_empat' => $rekap]);
        }

        return view('meeting-report.bidang-empat.rekap', compact('rekap'));
    }

    public function exportBidangEmpat()
    {
        $rekap = session('rekap_bidang_empat', []);

        if (empty($rekap)) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diexport.');
        }

        return Excel::download(new BidangEmpatExport($rekap), 'rekap_bidang_empat.xlsx');
    }

    // bidang empat end

    // sma start
    public function sma_create()
    {
        return view('meeting-report.sma.create');
    }

    public function storeSMA(Request $request)
    {
        try {
            $request->validate([
                'notulen' => 'required',
                'peserta' => 'nullable|array',
                'peserta.*' => 'string',
                'capture_image' => 'required|string',
                'waktu_rapat' => 'required|date',
            ]);

            $imageName = time() . '.png';
            $imagePath = public_path('meeting_photos/' . $imageName);
            file_put_contents($imagePath, file_get_contents($request->capture_image));

            MeetingReportSma::create([
                'notulen' => $request->notulen,
                'peserta' => $request->peserta,
                'capture_image' => 'meeting_photos/' . $imageName,
                'waktu_rapat' => $request->waktu_rapat,
            ]);

            return redirect()->back()->with('success', 'Laporan Meeting SMA berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function indexSMA()
    {
        $meetings = MeetingReportSma::latest()->get();
        return view('meeting-report.sma.index', compact('meetings'));
    }

    public function rekapSMA(Request $request)
    {
        $rekap = [];

        if ($request->filled(['dari', 'sampai'])) {
            $dari = Carbon::parse($request->dari)->startOfDay();
            $sampai = Carbon::parse($request->sampai)->endOfDay();

            $laporan = MeetingReportSma::whereBetween('waktu_rapat', [$dari, $sampai])->get();

            foreach ($laporan as $item) {
                $pesertaArray = is_string($item->peserta) ? json_decode($item->peserta, true) : $item->peserta;

                if (is_array($pesertaArray)) {
                    foreach ($pesertaArray as $nama) {
                        if (!isset($rekap[$nama])) {
                            $rekap[$nama] = 0;
                        }
                        $rekap[$nama]++;
                    }
                }
            }

            session(['rekap_sma' => $rekap]);
        }

        return view('meeting-report.sma.rekap', compact('rekap'));
    }

    public function exportSMA()
    {
        $rekap = session('rekap_sma', []);

        if (empty($rekap)) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diexport.');
        }

        return Excel::download(new MeetingReportSmaExport($rekap), 'rekap_sma.xlsx');
    }

    // sma end

    // smp start
    public function indexSMP()
    {
        $meetings = MeetingReportSmp::latest()->get();
        return view('meeting-report.smp.index', compact('meetings'));
    }

    public function smp_create()
    {
        return view('meeting-report.smp.create');
    }

    public function smp_store(Request $request)
    {
        logger($request->all());
        $request->validate([
            'notulen' => 'required|string',
            'peserta' => 'required|array',
            'capture_image' => 'nullable|string',
            'waktu_rapat' => 'required|date',
        ]);

        // MeetingReportSmp::create([
        //     'notulen' => $request->notulen,
        //     'peserta' => $request->peserta,
        //     'capture_image' => $request->capture_image,
        //     'waktu_rapat' => $request->waktu_rapat,
        // ]);

        MeetingReportSmp::create([
            'notulen' => $request->notulen,
            'peserta' => json_encode($request->peserta),
            'capture_image' => $request->capture_image,
            'waktu_rapat' => $request->waktu_rapat,
        ]);


        return redirect()->back()->with('success', 'Laporan berhasil disimpan.');
    }

    public function rekapSMP(Request $request)
    {
        $rekap = [];

        if ($request->filled(['dari', 'sampai'])) {
            $dari = Carbon::parse($request->dari)->startOfDay();
            $sampai = Carbon::parse($request->sampai)->endOfDay();

            $laporan = MeetingReportSmp::whereBetween('waktu_rapat', [$dari, $sampai])->get();

            foreach ($laporan as $item) {
                $pesertaArray = is_string($item->peserta) ? json_decode($item->peserta, true) : $item->peserta;

                if (is_array($pesertaArray)) {
                    foreach ($pesertaArray as $nama) {
                        if (!isset($rekap[$nama])) {
                            $rekap[$nama] = 0;
                        }
                        $rekap[$nama]++;
                    }
                }
            }

            session(['rekap_smp' => $rekap]);
        }

        return view('meeting-report.smp.rekap', compact('rekap'));
    }

    public function exportSMP()
    {
        $rekap = session('rekap_smp', []);

        if (empty($rekap)) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diexport.');
        }

        return Excel::download(new MeetingReportSmpExport($rekap), 'rekap_smp.xlsx');
    }

    // smp end

    // sd start
    public function sd_create()
    {
        $peserta = [
            'Annisa fatwa purnama',
            'Siti Fazri',
            'Febyanti Nur Fitriani',
            'Rise Fathonah',
            'Risna Ayu Siti Solihat',
            'Emma Kiki Maria',
            'Dedi Sopian',
            'Fitriani',
            'Ikhlas Naufal Marijan, S.Pd',
            'Yuni Yulianingsih',
            'Winda Rusmiati Purnama',
            'Amalia Nur Sabbila, S. Hum',
            'Intan Septiaranie Jannatun Naim',
            'Muhammad Said',
            'Lisda Nurhardiyanti',
            'NENG SRI HARDIANTI',
            'Weni Santika',
            'Silvi Noviani',
            'Ilham Nurzaman',
            'Risma Afrianti',
            'Firdausi Nuzula, S.Pd.',
            'Rangga Aditya Pratama',
            'Yasinta Amelia',
            'Sulaeman',
            'Heru Setio Darmaji',
            'Fetty Marwati Sanusi',
            'Hadian Sahidin',
            'Anisa Auliya',
            'Yuli Ratmawati',
            'Ayu Melani Nurjanah',
            'solehudin',
            'Rina Siti Mariam, S.Pd.',
            'Husni Aulia',
            'Syifa Amalia ',
            'Siti Mariah',
            'Enong Yulia',
            'Lia Aulia',
            'Dina Nur Hikmayati',
            'Hilmi Muhamad',
            'Tatan Desrina S.Pd.I',
            'Ida Nuryani',
            'Annisa islami M S.Ag',
            'Tita Komala Dewi',
            'Dilla Marliana Hidayanti',
            'Yulia Risdiana',
            'Tarisa Bintang Maharani',
            'Azalia Ratri Choerunisa',
            'Dini Nur Apriani',
            'Reza Dwi Putra Ramadhan',
        ];
        return view('meeting-report.sd.create', compact('peserta'));
    }

    public function sd_store(Request $request)
    {
        $request->validate([
            'notulen' => 'required|string',
            'peserta' => 'required|array',
            'capture_image' => 'nullable|string',
            'waktu_rapat' => 'required|date',
        ]);

        MeetingReportSD::create([
            'notulen' => $request->notulen,
            'peserta' => $request->peserta,
            'capture_image' => $request->capture_image,
            'waktu_rapat' => $request->waktu_rapat,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil disimpan.');
    }

    public function indexSD()
    {
        $meetings = MeetingReportSD::latest()->get();
        return view('meeting-report.sd.index', compact('meetings'));
    }

    public function rekapSD(Request $request)
    {
        $rekap = [];

        if ($request->filled(['dari', 'sampai'])) {
            $dari = Carbon::parse($request->dari)->startOfDay();
            $sampai = Carbon::parse($request->sampai)->endOfDay();

            $laporan = MeetingReportSd::whereBetween('waktu_rapat', [$dari, $sampai])->get();

            foreach ($laporan as $item) {
                $pesertaArray = is_string($item->peserta) ? json_decode($item->peserta, true) : $item->peserta;

                if (is_array($pesertaArray)) {
                    foreach ($pesertaArray as $nama) {
                        if (!isset($rekap[$nama])) {
                            $rekap[$nama] = 0;
                        }
                        $rekap[$nama]++;
                    }
                }
            }

            session(['rekap_sd' => $rekap]);
        }

        return view('meeting-report.sd.rekap', compact('rekap'));
    }

    public function exportSD()
    {
        $rekap = session('rekap_sd', []);

        if (empty($rekap)) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diexport.');
        }

        return Excel::download(new MeetingReportSdExport($rekap), 'rekap_sd.xlsx');
    }

    // sd end
}
