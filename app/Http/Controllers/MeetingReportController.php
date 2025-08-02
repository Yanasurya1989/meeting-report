<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MeetingReport;
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
use Illuminate\Support\Facades\Storage;

class MeetingReportController extends Controller
{
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
                'capture_image' => 'meeting_photos/' . $imageName, // path relatif ke public
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
        return view('meeting-report.bidang-satu.create');
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
    public function smp_create()
    {
        return view('meeting-report.smp.create');
    }

    public function indexSMP()
    {
        $meetings = MeetingReportSmp::latest()->get();
        return view('meeting-report.smp.index', compact('meetings'));
    }

    public function smp_store(Request $request)
    {
        $request->validate([
            'notulen' => 'required|string',
            'peserta' => 'required|array',
            'capture_image' => 'nullable|string',
            'waktu_rapat' => 'required|date',
        ]);

        MeetingReportSmp::create([
            'notulen' => $request->notulen,
            'peserta' => $request->peserta,
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
