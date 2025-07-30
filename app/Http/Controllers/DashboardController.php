<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MeetingReport;
use App\Models\MeetingReportBidang1;
use App\Models\MeetingReportBidang2;
use App\Models\MeetingReportBidang3;
use App\Models\MeetingReportSma;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $meetings = [
            'yayasan' => $this->limitNotulen(MeetingReport::orderBy('waktu_rapat', 'desc')->take(5)->get()),
            'bidang-satu' => $this->limitNotulen(MeetingReportBidang1::orderBy('waktu_rapat', 'desc')->take(5)->get()),
            'bidang-dua' => $this->limitNotulen(MeetingReportBidang2::orderBy('waktu_rapat', 'desc')->take(5)->get()),
            'bidang-tiga' => $this->limitNotulen(MeetingReportBidang3::orderBy('waktu_rapat', 'desc')->take(5)->get()),
            'bidang-empat' => $this->limitNotulen(MeetingReportBidang2::orderBy('waktu_rapat', 'desc')->take(5)->get()),
            'ks-sd' => $this->limitNotulen(MeetingReportBidang2::orderBy('waktu_rapat', 'desc')->take(5)->get()),
            'ks-smp' => $this->limitNotulen(MeetingReportBidang2::orderBy('waktu_rapat', 'desc')->take(5)->get()),
            'ks-sma' => $this->limitNotulen(MeetingReportSma::orderBy('waktu_rapat', 'desc')->take(5)->get()),
        ];

        $users = User::with('role')->get();
        return view('dashboard', compact('meetings', 'users'));
    }

    private function limitNotulen($collection)
    {
        return $collection->map(function ($item) {
            $item->notulen = Str::limit($item->notulen ?? 'Tanpa Judul', 10);
            return $item;
        });
    }
}
