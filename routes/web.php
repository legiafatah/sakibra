<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\AddJuriController;
use App\Http\Controllers\Admin\PenilaianController;
use App\Http\Controllers\Admin\HukumanController;
use App\Http\Controllers\Admin\RekapAdminController;
use App\Http\Controllers\Juri\HasilPenilaianController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\AddAdminController;
use App\Http\Middleware\SuperadminAuth;
use App\Models\HasilPenilaian;
use App\Models\Hukuman;
use Barryvdh\DomPDF\Facade\Pdf;



//admin
Route::middleware('AdminAuth')->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin_dashboard');
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('admin.penilaian');
    Route::get('/rekap', [RekapAdminController::class, 'rekapAdmin'])->name('admin_rekap');
    Route::get('/punishment', [HukumanController::class, 'index'])->name('admin_punishment');
    Route::patch('/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');
    Route::get('/hukuman', [HukumanController::class, 'index'])->name('hukuman_index');
    Route::post('/hukuman/store', [HukumanController::class, 'store'])->name('hukuman_store');
    Route::delete('/hukuman/{id}', [HukumanController::class, 'destroy'])->name('hukuman.destroy');
    //bbukti
    Route::delete('/bukti/{id}', [HukumanController::class, 'destroyBukti'])->name('bukti.destroy');
    Route::put('/hukuman/edit/{id}', [HukumanController::class, 'update'])->name('hukuman.update');

    Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta_index');
    Route::post('peserta/store', [PesertaController::class, 'store'])->name('peserta.store');
    Route::get('/peserta', [PesertaController::class, 'index'])->name('admin_peserta');
    Route::post('/peserta/toggle-status/{id}', [PesertaController::class, 'toggleStatus'])->name('peserta_toggle_status');
    Route::delete('/peserta/delete/{id}', [PesertaController::class, 'destroy'])->name('admin.peserta.destroy');
    Route::put('/peserta/update/{id}', [PesertaController::class, 'update'])->name('admin.peserta.update');

    Route::get('/juri', [AddJuriController::class, 'index'])->name('juri.index');
    Route::get('/juri/create', [AddJuriController::class, 'create'])->name('juri_create');
    Route::get('/juri/{id}/edit', [AddJuriController::class, 'edit'])->name('juri.edit');
    Route::post('/juri/store', [AddJuriController::class, 'storeJuri'])->name('juri_store');
    Route::delete('/juri/{id}', [AddJuriController::class, 'destroyJuri'])->name('juri.destroy');
    Route::patch('/juri/{id}/toggle-status', [AddJuriController::class, 'toggleStatus']);
    Route::put('/juri/edit/{id}', [AddJuriController::class, 'update'])->name('juri.update');
    Route::post('/akses-juri/simpan', [AddJuriController::class, 'storeAksesJuri'])->name('akses_juri.store');
    //baru
    Route::post('/penilaian/detailkategori/import', [PenilaianController::class, 'import'])->name('penilaian.detailkategori.import');
    Route::get('/penilaian/detailkategori/template', [PenilaianController::class, 'downloadTemplate'])->name('penilaian.detailkategori.template');


    Route::post('/hukuman/from-bukti', [HukumanController::class, 'storeFromBukti'])->name('hukuman_from_bukti');
    Route::get('/akses-juri', [AddJuriController::class, 'aksesJuri'])->name('akses-juri.index');
    Route::get('/detail-kategori', [PenilaianController::class, 'detailKategori'])->name('detail-kategori.index');
    Route::get('/bukti-hukuman', [HukumanController::class, 'bukti'])->name('bukti.index');
    Route::delete('/bukti', [HukumanController::class, 'destroyAll'])->name('bukti.destroy.all');

    
    Route::delete('/akses-juri/delete/{id}', [AddJuriController::class, 'destroyAksesJuri'])->name('akses.juri.destroy');
    Route::delete('/detail-kategori/delete/{id}', [PenilaianController::class, 'destroyDetail'])->name('detail.kategori.destroy');
    Route::put('/detail-kategori/update/{id}', [PenilaianController::class, 'updateDetail'])->name('detail.kategori.update');

    Route::put('/kategori/edit/{id}', [PenilaianController::class, 'updateKategori'])->name('kategori.update');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::post('/penilaian/kategori/simpan', [PenilaianController::class, 'simpanKategori'])->name('penilaian.kategori.simpan');
    Route::delete('/kategori/delete/{id}', [PenilaianController::class, 'destroyKategori'])->name('kategori.destroy');
    Route::get('/penilaian/kategori', [PenilaianController::class, 'kategoriForm'])->name('penilaian.kategori');
    Route::post('/penilaian/detail-kategori/simpan', [PenilaianController::class, 'simpanDetailKategori'])->name('penilaian.detailkategori.simpan');
    Route::get('/rekapitulasi/pdf', [RekapAdminController::class, 'exportPDF'])->name('rekapitulasi.pdf');



});
   
    Route::middleware('GuestAdmin')->get('admin/login', [AdminController::class, 'showLoginForm'])->name('admin_login');
    Route::post('/admin/login', [AdminController::class, 'login']);

    






//juri
Route::middleware('JuriAuth')->prefix('juri')->group(function () {

    Route::post('/logout', [HasilPenilaianController::class, 'logout'])->name('juri.logout');
    Route::get('/penilaian', [HasilPenilaianController::class, 'index'])->name('juri_penilaian');
    Route::get('/penilaian/{kategori}/mulai', [HasilPenilaianController::class, 'mulai'])->name('penilaian.mulai');
    Route::post('/penilaian/submit', [HasilPenilaianController::class, 'submit'])->name('penilaian.submit');
});
Route::middleware('GuestJuri')->get('juri/login', [HasilPenilaianController::class, 'showLoginForm'])->name('juri_login');
Route::post('/juri/login', [HasilPenilaianController::class, 'login']);


//user
Route::middleware('PesertaAuth')->prefix('user')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
    // Route::get('/rekap-detail', [UserController::class, 'detail'])->name('user.rekap-detail');
    Route::get('/rekap-peserta/pdf', [UserController::class, 'rekapPesertaPDF'])->name('rekap.peserta');
    Route::get('/dashboard', [UserController::class, 'detail'])->name('user.dashboard');
    Route::get('/hukuman', [UserController::class, 'hukuman'])->name('user.hukuman');


});
Route::middleware('GuestPeserta')->get('user/login', [UserController::class, 'showLoginForm'])->name('user.login');
Route::post('user/login', [UserController::class, 'login']);



//home
Route::get('/', function () {
    return view('home');
});

//superadmin
Route::middleware('SuperadminAuth')->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [SuperadminController::class, 'dashboard'])->name('superadmin_dashboard');
    Route::get('/admin/index', [AddAdminController::class, 'indexAdmin'])->name('admin_index');
    Route::get('/admin/create', [AddAdminController::class, 'createAdmin'])->name('admin_create');
    Route::post('/admin/store', [AddAdminController::class, 'storeAdmin'])->name('admin_store');
    Route::patch('/admin/{id}/toggle-status', [AddAdminController::class, 'toggleStatus'])->name('admin.toggleStatus');
    Route::patch('/superadmin/admin/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');
    Route::delete('/admin/{id}', [AddAdminController::class, 'destroy'])->name('admin.destroy');
    Route::post('/logout', [SuperadminController::class, 'logout'])->name('superadmin.logout');
});

Route::middleware('GuestSuperadmin')->get('superadmin/login', [SuperadminController::class, 'showLoginForm'])->name('superadmin_login');
Route::post('superadmin/login', [SuperadminController::class, 'login']);