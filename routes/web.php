<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingReportController;
use App\Exports\RekapKehadiranExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('meeting/{divisi}', [MeetingReportController::class, 'index'])->name('meeting.index');

// Yayasan
Route::get('/meeting/create/yayasan', [MeetingReportController::class, 'create'])->name('meeting.create.yayasan');
Route::post('/meeting/store', [MeetingReportController::class, 'store'])->name('meeting.store');
Route::get('/meeting-report', [MeetingReportController::class, 'index'])->name('meeting.index');
Route::get('meeting/rekap/yayasan', [App\Http\Controllers\MeetingReportController::class, 'rekap'])->name('rekap.peserta');

// Bidang Satu
Route::get('/meeting/create/bidang-satu', [MeetingReportController::class, 'bidang_satu_create'])->name('meeting.create.bidang_satu');
Route::post('/bidang-1/store', [MeetingReportController::class, 'bidang_satu_store'])->name('bidang1.store');
Route::get('/meeting/index/bidang-satu', [MeetingReportController::class, 'bidang_satu_index'])->name('meeting.bidang-satu.index');
Route::get('meeting/rekap/bidang-satu', [MeetingReportController::class, 'rekapBidangSatu'])->name('rekap.bidang-satu');

// BIDANG DUA
Route::get('meeting/create/bidang-dua', [MeetingReportController::class, 'bidang_dua_create'])->name('meeting.bidang_dua_create');
Route::get('/bidang-2/create', [MeetingReportController::class, 'bidang_dua_create'])->name('bidang2.create');
Route::post('/bidang-2/store', [MeetingReportController::class, 'bidang_dua_store'])->name('bidang2.store');
Route::get('meeting/rekap/bidang-dua', [MeetingReportController::class, 'rekapBidangDua'])->name('rekap.bidang-dua');
Route::get('/meeting/index/bidang-dua', [MeetingReportController::class, 'indexBidangDua'])->name('meeting.bidang-dua.index');

// BIdang Tiga
Route::get('/meeting/create/bidang-tiga', [MeetingReportController::class, 'bidang_tiga_create'])->name('meeting.create.bidang_tiga');
Route::get('/meeting/index/bidang-tiga', [MeetingReportController::class, 'indexBidangTiga'])->name('meeting.bidang-tiga.index');
Route::post('/meeting/bidang3/store', [MeetingReportController::class, 'storeBidangTiga'])->name('meeting.bidang3.store');

// Bidang Empat
Route::get('/meeting/index/bidang-empat', [MeetingReportController::class, 'indexBidangTiga'])->name('meeting.bidang-empat.index');

// Bidang ks-sd
Route::get('/meeting/index/ks-sd', [MeetingReportController::class, 'indexBidangTiga'])->name('meeting.ks-sd.index');

// Bidang ks-smp
Route::get('/meeting/index/ks-smp', [MeetingReportController::class, 'indexBidangTiga'])->name('meeting.ks-smp.index');

// Bidang ks-sma
Route::get('/meeting/index/ks-sma', [MeetingReportController::class, 'indexBidangTiga'])->name('meeting.ks-sma.index');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/export-kehadiran', function () {
    $rekap = session('rekap'); // Ambil dari session
    return Excel::download(new RekapKehadiranExport($rekap), 'rekap-kehadiran.xlsx');
})->name('kehadiran.export');

$menus = ['yayasan', 'bidang1', 'bidang2', 'bidang3', 'bidang4', 'sma', 'smp', 'sd'];

foreach ($menus as $menu) {
    Route::get($menu, function () use ($menu) {
        return view('dashboard', ['menu' => ucfirst($menu)]);
    });
}

// Route::get('/', function () {
//     return view('dashboard');
// })->name('dashboard');
