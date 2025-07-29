<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MeetingReport;
use App\Models\MeetingReportBidang1;
use App\Models\MeetingReportBidang2;
use App\Models\MeetingReportBidang3;
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

                if (is_array($pesertaArray)) {
                    foreach ($pesertaArray as $nama) {
                        if (!isset($rekap[$nama])) {
                            $rekap[$nama] = 0;
                        }
                        $rekap[$nama]++;
                    }
                }
            }

            session(['rekap_bidang_satu' => $rekap]); // untuk keperluan export excel bidang 1
        }

        return view('meeting-report.bidang-satu.rekap', compact('rekap'));
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

    public function indexBidangDua()
    {
        $laporan = MeetingReportBidang2::latest()->get();

        return view('meeting-report.bidang-dua.index', compact('laporan'));
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
        return view('meeting.bidang-tiga.index', compact('meetings'));
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
    // bidang tiga end
}
