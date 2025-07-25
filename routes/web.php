<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingReportController;
use App\Exports\RekapKehadiranExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/meeting/create', [MeetingReportController::class, 'create'])->name('meeting.create');
Route::post('/meeting/store', [MeetingReportController::class, 'store'])->name('meeting.store');

Route::get('/meeting-report', [MeetingReportController::class, 'index'])->name('meeting.index');
Route::get('/rekap-peserta', [App\Http\Controllers\MeetingReportController::class, 'rekap'])->name('rekap.peserta');


Route::get('/', function () {
    return view('dashboard');
});
