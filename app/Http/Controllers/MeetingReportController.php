<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeetingReport;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MeetingReportController extends Controller
{
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

            ]);

            return redirect()->back()->with('success', 'Data meeting berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data meeting: ' . $e->getMessage());
        }
    }
}
