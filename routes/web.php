<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserVisiMisiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KelolaPenggunaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\Admin\StrukturController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\ZoomController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\ZoomAdminController;
use App\Http\Controllers\Admin\MasterPlanController;
use App\Http\Controllers\Admin\SejarahController;
use App\Http\Controllers\Admin\EmailAdminController;
use App\Http\Controllers\Admin\LaporanAdminController;
use App\Http\Controllers\Admin\HotspotAdminController;
use App\Http\Controllers\Admin\SubDomainAdminController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\MasterPlaneController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HotspotController;
use App\Http\Controllers\SubDomainController;
use App\Http\Controllers\EmailLembagaController;
use App\Http\Controllers\EmailPribadiController;
use App\Http\Controllers\SejarahUserController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\RequestController;
use App\Models\Fasilitas;
use App\Http\Controllers\Operator\OperatorProfileController;

/*

|--------------------------------------------------------------------------
| 1. ROUTE HALAMAN UTAMA
|--------------------------------------------------------------------------
*/
Route::get('/', [DashboardUserController::class, 'index'])->name('home');
Route::get('/berita/{id}', [DashboardUserController::class,'showBerita'])->name('berita.show');
Route::put('/admin/kelola-pengguna/approve/{id}',
[KelolaPenggunaController::class,'approve'])
->name('admin.user.approve');

/*
|--------------------------------------------------------------------------
| ROUTE BYPASS CADANGAN (SINKRONISASI POLA URL DENGAN GRUP ADMIN & BLADE)
|--------------------------------------------------------------------------
*/
Route::post('/admin/email-pribadi/{id}/tolak', [EmailAdminController::class, 'tolakPribadi'])->middleware(['auth']);
/*opertor*/
    Route::get('/kelolahospot', [HotspotAdminController::class, 'index'])->name('admin.hotspot.index');
    Route::get('/kelolahospot/show/{id}', [HotspotAdminController::class, 'show'])->name('admin.hotspot.show');
    Route::post('/kelolahospot/store/{id}', [HotspotAdminController::class, 'storeCredentials'])->name('admin.hotspot.storeCredentials');
    Route::post('/kelolahospot/tolak/{id}', [HotspotAdminController::class, 'tolak'])->name('admin.hotspot.tolak');
    Route::delete('/kelolahospot/{id}', [HotspotAdminController::class, 'destroy'])->name('admin.hotspot.destroy');
    Route::post('/kelolahospot/sync/{id}', [HotspotAdminController::class, 'syncManual'])->name('admin.hotspot.sync');
    
Route::get('/laporan', [LaporanAdminController::class, 'index'])->name('admin.laporan.index');
    Route::get('/laporan/{id}', [LaporanAdminController::class, 'show'])->name('admin.laporan.show');
    
    Route::patch('/laporan/{id}/terima', [LaporanAdminController::class, 'terima'])->name('admin.laporan.terima');
    Route::delete('/laporan/{id}', [LaporanAdminController::class, 'destroy'])->name('admin.laporan.destroy');
    Route::patch('/laporan/{id}/update-status', [LaporanAdminController::class, 'updateStatus'])->name('admin.laporan.updateStatus');

// Kelola Request Zoom 
    Route::get('/zoom', [ZoomAdminController::class, 'index'])->name('admin.zoom.index');
    Route::get('/zoom/{id}', [ZoomAdminController::class, 'show'])->name('admin.zoom.show');
    Route::post('/zoom/{id}/approve', [ZoomAdminController::class, 'approve'])->name('admin.zoom.approve');
    Route::delete('/zoom/{id}', [ZoomAdminController::class,'delete'])->name('admin.zoom.delete');

    // UPDATE/EDIT DATA PENGAJUAN ZOOM (SAMA DENGAN HOSTING)
    Route::put('/zoom/update/{id}', [ZoomAdminController::class, 'update'])->name('admin.zoom.update');

    // TAMBAHAN BARU: ROUTE NONAKTIFKAN ZOOM (SINKRON DENGAN BLADE PENGAJUAN)
    Route::post('/zoom/{id}/disable', [ZoomAdminController::class, 'disable'])->name('admin.zoom.disable');

    /**
     * PROTEKSI TAMBAHAN (ANTI ERROR 405 METHOD NOT ALLOWED - ZOOM)
     * Menangkap request GET tidak sengaja ke URL update data Zoom
     */
    Route::get('/zoom/update/{id}', function() {
        return redirect()->route('admin.zoom.index')
            ->with('error', 'Sesi form edit Zoom telah kedaluwarsa atau metode akses salah.');
    });

    // TAMBAHAN FIX: PROTEKSI ANTI 405 UNTUK METHOD GET DISABLE ZOOM
    Route::get('/zoom/{id}/disable', function() {
        return redirect()->route('admin.zoom.index')
            ->with('error', 'Metode akses tidak valid. Aksi penonaktifkan harus melalui form POST.');
    });
Route::prefix('operator')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/profile', [OperatorProfileController::class,'index'])
            ->name('operator.profile');

        Route::put('/profile/update', [OperatorProfileController::class,'update'])
            ->name('operator.profile.update');

});

/*
|--------------------------------------------------------------------------
| 2. ROUTE ADMIN (DENGAN MIDDLEWARE AUTH)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\NotificationController;

Route::get('/admin/notifikasi', [NotificationController::class, 'index'])
    ->name('admin.notifikasi');

Route::get('/admin/notifikasi/read-all', [NotificationController::class, 'readAll'])
    ->name('admin.notifikasi.readAll');

// untuk badge notif
Route::get('/admin/notifikasi/count', function () {
    return response()->json([
        'count' => \App\Models\Notification::where('is_read', 0)->count()
    ]);
})->name('admin.notif.count');

Route::prefix('admin')->middleware(['auth'])->group(function () {

    // Dashboard & Profil Admin
    // DISABLE MENU BARU ZOOM UNTUK MANAGEMENT JIKA DI PERLUKAN
    Route::get('/keloladashboard', [DashboardController::class, 'index'])->name('admin.keloladashboard');
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
 
    // Laporan Admin
    // UPDATE STATUS & MANAGE COMPLAINTS
    
    // Kelola Pengguna
    // (DIBAWAH ADALAH KODE ASLI - DIPERBAIKI KARAKTER WHITESPACE TERSEBUNYI JIKA ADA)
    Route::get('/kelola-pengguna', [UserController::class,'index'])->name('admin.kelolapengguna');
    Route::post('/kelola-pengguna/store', [UserController::class,'store'])->name('admin.user.store');
    Route::put('/kelola-pengguna/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/kelola-pengguna/{id}', [UserController::class,'destroy'])->name('admin.user.destroy');
    Route::post('/kelola-pengguna/upload', [UserController::class,'uploadExcel'])->name('admin.user.upload');

    // Konten Dashboard
    // LAYANAN
    Route::post('/layanan', [DashboardController::class, 'storeLayanan'])->name('admin.layanan.store');
    Route::put('/layanan/{id}', [DashboardController::class, 'updateLayanan'])->name('admin.layanan.update');
    Route::delete('/layanan/{id}', [DashboardController::class, 'deleteLayanan'])->name('admin.layanan.delete');
    // PENGUMUMAN
    Route::post('/pengumuman', [DashboardController::class, 'storePengumuman'])->name('admin.pengumuman.store');
    Route::put('/pengumuman/{id}', [DashboardController::class, 'updatePengumuman'])->name('admin.pengumuman.update');
    Route::delete('/pengumuman/{id}', [DashboardController::class, 'deletePengumuman'])->name('admin.pengumuman.delete');
    // KEGIATAN
    Route::post('/kegiatan', [DashboardController::class, 'storeKegiatan'])->name('admin.kegiatan.store');
    Route::put('/kegiatan/{id}', [DashboardController::class, 'updateKegiatan'])->name('admin.kegiatan.update');
    Route::delete('/kegiatan/{id}', [DashboardController::class, 'deleteKegiatan'])->name('admin.kegiatan.delete');

    // Master Data
    Route::get('/visimisi', [VisiMisiController::class, 'index'])->name('admin.visimisi.index');
    Route::post('/kelolavisimisi', [VisiMisiController::class, 'store'])->name('admin.visimisi.store');
    
    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('kelolafasilitas');
    Route::post('/fasilitas', [FasilitasController::class, 'store'])->name('fasilitas.store');
    Route::put('/fasilitas/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update'); 
    Route::delete('/fasilitas/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy'); 
    Route::delete('/fasilitas/gambar/{id}', [FasilitasController::class, 'destroyGambar'])->name('fasilitas.gambar.destroy');
    
    Route::get('/faq', [AdminFaqController::class, 'index'])->name('kelolafaq');
    Route::post('/faq', [AdminFaqController::class, 'store'])->name('admin.faq.store');
    Route::get('/faq/{faq}/edit', [AdminFaqController::class, 'edit'])->name('admin.faq.edit');
    Route::put('/faq/{faq}', [AdminFaqController::class, 'update'])->name('admin.faq.update');
    Route::delete('/faq/{faq}', [AdminFaqController::class, 'destroy'])->name('admin.faq.destroy');
    Route::get('/masterplan', [MasterPlanController::class, 'index'])->name('admin.kelolamasterplane');
    Route::post('/masterplan/store', [MasterPlanController::class, 'store'])->name('admin.masterplan.store');
    Route::delete('/masterplan/{id}', [MasterPlanController::class, 'destroy'])->name('admin.masterplan.delete');

    // Struktur Organisasi
    Route::get('/struktur', [StrukturController::class, 'index'])->name('admin.struktur');
    Route::post('/divisi', [StrukturController::class, 'storeDivisi'])->name('admin.divisi.store');
    Route::post('/anggota', [StrukturController::class, 'storeAnggota'])->name('admin.anggota.store');
    Route::post('/struktur/gambar', [StrukturController::class, 'updateGambar'])->name('admin.struktur.updateGambar');
    Route::delete('/anggota/{id}', [StrukturController::class, 'deleteAnggota'])->name('admin.anggota.delete');
    Route::delete('/divisi/{id}', [StrukturController::class, 'deleteDivisi'])->name('admin.divisi.delete');

    // Email Management (Admin)
    Route::get('/kelolaemail', [EmailAdminController::class, 'index'])->name('admin.kelolaemail');
    Route::get('/email-lembaga/{id}', [EmailAdminController::class, 'detailLembaga'])->name('admin.email.detail');
    Route::post('/email-lembaga/setuju/{id}', [EmailAdminController::class, 'setujuLembaga'])->name('admin.email.setuju');
    Route::post('/email-lembaga/tolak/{id}', [EmailAdminController::class, 'tolakLembaga'])->name('admin.email.tolak');
    Route::get('/email-pribadi/{id}', [EmailAdminController::class, 'detailPribadi'])->name('admin.emailpribadi.detail');
    Route::post('/email-pribadi/{id}/setuju', [EmailAdminController::class, 'setujuPribadi'])->name('admin.emailpribadi.setuju');
    Route::post('/email-pribadi/{id}/tolak', [EmailAdminController::class, 'tolakPribadi'])->name('admin.emailpribadi.tolak');
    Route::delete('/email-lembaga/{id}', [EmailAdminController::class, 'destroyLembaga'])->name('admin.email.destroy');
    Route::delete('/email-pribadi/{id}', [EmailAdminController::class, 'destroyPribadi'])->name('admin.emailpribadi.destroy');

    // Subdomain Management (Admin)
    Route::post(
        '/subdomain/{id}/reject',
        [SubDomainAdminController::class, 'reject']
    )->name('admin.subdomain.reject');

    Route::post(
        '/subdomain/{id}/disable',
        [SubDomainAdminController::class, 'disable']
    )->name('admin.subdomain.disable');

    Route::get('/subdomain', [SubDomainAdminController::class, 'index'])->name('admin.subdomain.index');
    Route::get('/subdomain/{id}', [SubDomainAdminController::class, 'show'])->name('admin.subdomain.detail');
    Route::post('/subdomain/{id}/approve', [SubDomainAdminController::class, 'approve'])->name('admin.subdomain.approve');
    Route::delete('/subdomain/{id}', [SubDomainAdminController::class, 'destroy'])->name('admin.subdomain.destroy');
    
    // =======================================================================
    // KODE BARU: FIX UNTUK ROUTE NOT FOUND [admin.subdomain.show]
    // Mendefinisikan alias name agar sistem mengenali 'admin.subdomain.show'
    // =======================================================================
    Route::get('/subdomain/{id}/show', [SubDomainAdminController::class, 'show'])->name('admin.subdomain.show');
    // =======================================================================

    // UPDATE/EDIT DATA PENGAJUAN SUBDOMAIN & HOSTING (LENGKAP)
    Route::put('/subdomain/update/{id}', [SubDomainAdminController::class, 'update'])->name('admin.subdomain.update');

    // KODE BARU: ROUTE UNTUK UPDATE PARAMETER KONFIGURASI HOSTING SAJA
    Route::put('/subdomain/{id}/update-hosting', [SubDomainAdminController::class, 'updateHosting'])->name('admin.subdomain.update-hosting');

    /**
     * PROTEKSI TAMBAHAN (ANTI ERROR 405 METHOD NOT ALLOWED)
     */
    Route::get('/subdomain/update/{id}', function() {
        return redirect()->route('admin.subdomain.index')
            ->with('error', 'Request tidak valid atau sesi form telah kedaluwarsa. Silakan coba kembali.');
    });
});
use App\Http\Controllers\Admin\HalamanUtamaController;

Route::middleware(['auth'])->prefix('admin')->group(function(){

    Route::get('/dashboard', [HalamanUtamaController::class, 'index'])
        ->name('admin.dashboard');

});

/*
|--------------------------------------------------------------------------
| ADMIN LEVEL KHUSUS (HOTSPOT & ZOOM)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','admin'])->prefix('admin')->group(function () {
    Route::get('/kelolahospot', [HotspotAdminController::class, 'index'])->name('admin.hotspot.index');
    Route::get('/kelolahospot/show/{id}', [HotspotAdminController::class, 'show'])->name('admin.hotspot.show');
    Route::post('/kelolahospot/store/{id}', [HotspotAdminController::class, 'storeCredentials'])->name('admin.hotspot.storeCredentials');
    Route::post('/kelolahospot/tolak/{id}', [HotspotAdminController::class, 'tolak'])->name('admin.hotspot.tolak');
    Route::delete('/kelolahospot/{id}', [HotspotAdminController::class, 'destroy'])->name('admin.hotspot.destroy');
    Route::post('/kelolahospot/sync/{id}', [HotspotAdminController::class, 'syncManual'])->name('admin.hotspot.sync');
    
    });

// Sejarah
Route::get('/kelolasejarah', [SejarahController::class, 'index'])->name('kelolasejarah');
Route::post('/kelolasejarah', [SejarahController::class, 'store'])->name('sejarah.simpan');
Route::post('/kelolasejarah/upload', [SejarahController::class, 'uploadGambar'])->name('sejarah.upload');
Route::delete('/kelolasejarah/gambar/{id}', [SejarahController::class, 'deleteGambar'])->name('sejarah.delete');

/*
|--------------------------------------------------------------------------
| 3. ROUTE AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'registerStore'])->name('register.store');
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', function() {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout.get');

/*
|--------------------------------------------------------------------------
| 4. ROUTE USER (SINKRONISASI EMAIL LEMBAGA)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardUserController::class, 'index'])->name('dashboard');
Route::get('/visi-misi', [UserVisiMisiController::class, 'index'])->name('user.visimisi');
Route::get('/struktur', [StrukturController::class, 'tampilUser'])->name('struktur');
Route::get('/masterplane', [MasterPlaneController::class, 'index'])->name('masterplane');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/sejarah', [SejarahUserController::class, 'index'])->name('user.sejarah');
Route::get('/resetpasswordemail', function () { return view('user.resetpassemail'); })->name('resetpasswordemail');

Route::get('/fasilitas', function () {
    $fasilitas = Fasilitas::with('gambar')->get();
    return view('user.fasilitas', compact('fasilitas'));
})->name('fasilitas');

Route::middleware(['auth'])->group(function () {
    // User Profile
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // Zoom Request
    Route::get('/zoom/request', [ZoomController::class, 'create'])->name('zoom.create');
    Route::post('/zoom/request', [ZoomController::class, 'store'])->name('zoom.store');
    Route::get('/pilihemail', function () { return view('user.pilihemail'); })->name('pilihemail');
    
    // Hotspot User
    Route::get('/hotspot', [HotspotController::class, 'create'])->name('hotspot.form');
    Route::post('/hotspot/store', [HotspotController::class, 'store'])->name('hotspot.store'); 
    Route::get('/hotspot-saya', [HotspotController::class, 'myHotspot'])->name('hotspot.my');
    Route::get('/hotspot-saya/{id}', [HotspotController::class, 'show'])->name('hotspot.show');
    Route::delete('/hotspot-saya/{id}', [HotspotController::class, 'destroy'])->name('hotspot.destroy');
    
    // Domain Request
    Route::get('/request-domain', [SubDomainController::class, 'create'])->name('requestdomain');
    Route::post('/request-domain', [SubDomainController::class, 'store'])->name('requestdomain.store');
    
    // Laporan & Tracking
    Route::get('/pengajuan', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/pengajuan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/tracking-laporan', [LaporanController::class, 'tracking'])->name('laporan.tracking');
    Route::get('/tracking', [LaporanController::class, 'tracking'])->name('tracking');
    Route::get('/tracking/{id}', [LaporanController::class, 'show'])->name('laporan.show_user');

    // Email Pribadi
    Route::get('/permohonan/email-pribadi', [EmailPribadiController::class, 'index'])->name('email-pribadi.index');
    Route::post('/permohonan/email-pribadi', [EmailPribadiController::class, 'store'])->name('email-pribadi.store');
    
    // Layanan & Permintaan
    Route::post('/request-layanan',[ServiceRequestController::class,'store'])->name('request.layanan');
    Route::get('/permintaan-saya', [RequestController::class,'index'])->name('permintaan.saya');

    // PERBAIKAN EMAIL LEMBAGA (PENYESUAIAN ALIAS)
    Route::get('/permohonan-email', [EmailLembagaController::class, 'create'])->name('permohonan-email.index');
    Route::post('/permohonan-email', [EmailLembagaController::class, 'store'])->name('email-lembaga.store');
});

/*
|--------------------------------------------------------------------------
| 5. MAINTENANCE & OPTIMIZATION TOOLS
|--------------------------------------------------------------------------
*/
Route::get('/jalankan-optimize', function() {
    try {
        Artisan::call('optimize:clear');
        Artisan::call('optimize');
        Artisan::call('view:clear');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        return "<h1>🔥 Sistem Berhasil Dioptimasi!</h1><p>Semua cache telah bersihkan dan dimuat ulang.</p><a href='/'>Kembali ke Beranda</a>";
    } catch (\Exception $e) { return "Gagal: " . $e->getMessage(); }
});

Route::get('/clear-cache', function() {
    try {
        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        return "<h1>Cache Berhasil Dihapus!</h1><p>Silakan refresh halaman Anda.</p>";
    } catch (\Exception $e) { return "Gagal: " . $e->getMessage(); }
});

Route::get('/fix-storage', function () {
    try {
        Artisan::call('storage:link');
        return "<h1>Symlink Berhasil!</h1><a href='/'>Kembali</a>";
    } catch (\Exception $e) { return "Error: " . $e->getMessage(); }
});

Route::get('/profile',[ProfileController::class,'show'])->name('profile');
Route::put('/profile/update',[ProfileController::class,'update'])->name('profile.update');