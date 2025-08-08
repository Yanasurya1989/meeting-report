<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingReportController;
use App\Exports\RekapKehadiranExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('meeting/{divisi}', [MeetingReportController::class, 'index'])->name('meeting.index');
// routes/web.php
Route::get('/get-users-by-divisi/{id}', [MeetingReportController::class, 'getUsersByDivisi']);

// Yayasan
Route::get('/meeting/create/yayasan', [MeetingReportController::class, 'create'])->name('meeting.create.yayasan');
Route::post('/meeting/store', [MeetingReportController::class, 'store'])->name('meeting.store');
Route::get('/meeting-report', [MeetingReportController::class, 'index'])->name('meeting.index');
Route::get('meeting/rekap/yayasan', [App\Http\Controllers\MeetingReportController::class, 'rekap'])->name('rekap.peserta');

// Bidang Satu
Route::get('/meeting/create/bidang-satu', [MeetingReportController::class, 'bidang_satu_create'])->name('meeting.create.bidang_satu');
Route::post('/bidang-1/store', [MeetingReportController::class, 'bidang_satu_store'])->name('bidang1.store');
Route::get('/meeting/index/bidang-satu', [MeetingReportController::class, 'bidang_satu_index'])->name('meeting.bidang-satu.index');
Route::get('/meeting/rekap/bidang-satu', [MeetingReportController::class, 'rekapBidangSatu'])->name('rekap.bidang-satu');
Route::get('/meeting/export/bidang-satu', [MeetingReportController::class, 'exportBidangSatu'])->name('export.bidang-satu');


// BIDANG DUA
Route::get('meeting/create/bidang-dua', [MeetingReportController::class, 'bidang_dua_create'])->name('meeting.bidang_dua_create');
Route::get('/bidang-2/create', [MeetingReportController::class, 'bidang_dua_create'])->name('bidang2.create');
Route::post('/bidang-2/store', [MeetingReportController::class, 'bidang_dua_store'])->name('bidang2.store');
Route::get('/meeting/export/bidang-dua', [MeetingReportController::class, 'exportBidangDua'])->name('export.bidang-dua');
Route::get('/meeting/rekap/bidang-dua', [MeetingReportController::class, 'rekapBidangDua'])->name('rekap.bidang-dua');
Route::get('/meeting/index/bidang-dua', [MeetingReportController::class, 'indexBidangDua'])->name('meeting.bidang-dua.index');

// BIdang Tiga
Route::get('/meeting/create/bidang-tiga', [MeetingReportController::class, 'bidang_tiga_create'])->name('meeting.create.bidang_tiga');
Route::get('/meeting/index/bidang-tiga', [MeetingReportController::class, 'indexBidangTiga'])->name('meeting.bidang-tiga.index');
Route::post('/meeting/bidang3/store', [MeetingReportController::class, 'storeBidangTiga'])->name('meeting.bidang3.store');
Route::get('meeting/rekap/bidang-tiga', [MeetingReportController::class, 'rekapBidangTiga'])->name('rekap.bidang-tiga');
Route::get('/bidang-3/export', [MeetingReportController::class, 'exportBidangTiga'])->name('bidang3.export');

// Bidang Empat
Route::get('/meeting/create/bidang-empat', [MeetingReportController::class, 'bidang_empat_create'])->name('meeting.create.bidang_empat');
Route::get('/meeting/index/bidang-empat', [MeetingReportController::class, 'indexBidangEmpat'])->name('meeting.bidang-empat.index');
Route::post('/meeting/bidang4/store', [MeetingReportController::class, 'storeBidangEmpat'])->name('meeting.bidang4.store');
Route::get('/meeting/rekap/bidang-empat', [MeetingReportController::class, 'rekapBidangEmpat'])->name('rekap.bidang-empat');
Route::get('/bidang-4/export', [MeetingReportController::class, 'exportBidangEmpat'])->name('bidang4.export');

// Bidang ks-sma
Route::get('/sma/create', [MeetingReportController::class, 'sma_create'])->name('sma.create');
// Route::get('/meeting/index/sma', [MeetingReportController::class, 'indexSMA'])->name('meeting.sma.index');
Route::get('/meeting/index/sma', [MeetingReportController::class, 'indexSMA'])->name('meeting.sma.index');
Route::post('/sma/store', [MeetingReportController::class, 'storeSMA'])->name('sma.store');
Route::get('/meeting/rekap/sma', [MeetingReportController::class, 'rekapSMA'])->name('rekap.sma');
Route::get('/sma/export', [MeetingReportController::class, 'exportSMA'])->name('sma.export');

// Bidang ks-sd
// Route::get('/sd', [MeetingReportController::class, 'indexSD'])->name('meeting.ks-sd.index');
Route::get('/meeting/ks-sd/index', [MeetingReportController::class, 'indexSD'])->name('meeting.sd.index');
Route::get('/meeting/index/sd', [MeetingReportController::class, 'indexSD'])->name('meeting.sd.index');
Route::get('/sd/create', [MeetingReportController::class, 'sd_create'])->name('meeting.create.sd');
Route::post('/sd/store', [MeetingReportController::class, 'sd_store'])->name('sd.store');
Route::get('meeting/rekap/sd', [MeetingReportController::class, 'rekapSD'])->name('rekap.sd');
Route::get('rekap/sd/export', [MeetingReportController::class, 'exportSD'])->name('rekap.sd.export');


// Bidang ks-smp
Route::get('/smp/create', [MeetingReportController::class, 'smp_create'])->name('meeting.create.smp');
Route::get('/meeting/index/smp', [MeetingReportController::class, 'indexSMP'])->name('meeting.smp.index');
Route::post('/smp/store', [MeetingReportController::class, 'smp_store'])->name('smp.store');
Route::get('meeting/rekap/smp', [MeetingReportController::class, 'rekapSMP'])->name('rekap.smp');
Route::get('rekap/smp/export', [MeetingReportController::class, 'exportSMP'])->name('rekap.smp.export');


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

Route::post('/all-sub-divisi-store', [App\Http\Controllers\MeetingReportController::class, 'allSubDivisiStore'])
    ->name('all-sub-divisi-store');
