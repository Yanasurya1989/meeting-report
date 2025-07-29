<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MeetingReport;
use App\Models\MeetingReportBidang1;
use App\Models\MeetingReportBidang2;
use App\Models\MeetingReportBidang3;

class DashboardController extends Controller
{
    public function index()
    {
        $meetings = [
            'yayasan' => MeetingReport::orderBy('waktu_rapat', 'desc')->take(5)->get(),
            'bidang-satu' => MeetingReportBidang1::orderBy('waktu_rapat', 'desc')->take(5)->get(),
            'bidang-dua' => MeetingReportBidang2::orderBy('waktu_rapat', 'desc')->take(5)->get(),
            'bidang-tiga' => MeetingReportBidang3::orderBy('waktu_rapat', 'desc')->take(5)->get(),
            'bidang-empat' => MeetingReportBidang2::orderBy('waktu_rapat', 'desc')->take(5)->get(),
            'ks-sd' => MeetingReportBidang2::orderBy('waktu_rapat', 'desc')->take(5)->get(),
            'ks-smp' => MeetingReportBidang2::orderBy('waktu_rapat', 'desc')->take(5)->get(),
            'ks-sma' => MeetingReportBidang2::orderBy('waktu_rapat', 'desc')->take(5)->get(),

        ];
        $users = User::with('role')->get();
        return view('dashboard', compact('meetings', 'users'));
    }
}
