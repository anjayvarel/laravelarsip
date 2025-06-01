<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Admin\AdminSuratController;
use App\Http\Controllers\Staff\StaffSuratController;
use App\Http\Controllers\Admin\AdminAgendaController;
use App\Http\Controllers\Staff\StaffAgendaController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ProfileController;


// ======================
// 🚀 HALAMAN UTAMA (Redirect ke Login atau Dashboard)
// ======================
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role == 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('staff.dashboard');
    }
    return redirect()->route('login');
});

// ======================
// 🚀 AUTH ROUTES (LOGIN & LOGOUT)
// ======================
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

// ======================
// 🚀 ADMIN ROUTES
// ======================
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/surat/cetak', [AdminSuratController::class, 'cetak'])->name('admin.surat.cetak');


        // Surat Masuk & Keluar untuk Admin
        Route::get('/surat-masuk', [AdminSuratController::class, 'indexMasuk'])->name('admin.surat.masuk');
        Route::get('/surat-keluar', [AdminSuratController::class, 'indexKeluar'])->name('admin.surat.keluar');

        // CRUD Surat untuk Admin
        Route::get('/surat/create', [AdminSuratController::class, 'create'])->name('admin.surat.create');
        Route::post('/surat/store', [AdminSuratController::class, 'store'])->name('admin.surat.store');
        Route::get('/surat/{surat}/edit', [AdminSuratController::class, 'edit'])->name('admin.surat.edit');
        Route::put('/surat/{surat}', [AdminSuratController::class, 'update'])->name('admin.surat.update');
        Route::delete('/surat/{id}', [AdminSuratController::class, 'destroy'])->name('admin.surat.destroy');


        // CRUD Agenda Acara untuk Admin
        Route::get('/agenda', [AdminAgendaController::class, 'index'])->name('admin.agenda.index');
        Route::get('/agenda/create', [AdminAgendaController::class, 'create'])->name('admin.agenda.create');
        Route::post('/agenda/store', [AdminAgendaController::class, 'store'])->name('admin.agenda.store');
        Route::delete('/agenda/{agenda}', [AdminAgendaController::class, 'destroy'])->name('admin.agenda.destroy');
        Route::get('/agenda/{agenda}/edit', [AdminAgendaController::class, 'edit'])->name('admin.agenda.edit');
        Route::put('/agenda/{agenda}', [AdminAgendaController::class, 'update'])->name('admin.agenda.update');
        Route::get('/agenda/events', [AdminAgendaController::class, 'getEvents'])->name('admin.agenda.events');
        Route::post('/agenda/ajax-save', [AdminAgendaController::class, 'ajaxStoreOrUpdate'])->name('admin.agenda.ajax-save');



        // CRUD Kategori untuk Admin
        Route::get('/kategori', [AdminKategoriController::class, 'index'])->name('admin.kategori.index');
        Route::get('/kategori/create', [AdminKategoriController::class, 'create'])->name('admin.kategori.create');
        Route::post('/kategori/store', [AdminKategoriController::class, 'store'])->name('admin.kategori.store');
        Route::delete('/kategori/{kategori}', [AdminKategoriController::class, 'destroy'])->name('admin.kategori.destroy');

        // CRUD Kelola Pengguna untuk Admin
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/users/store', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
        Route::get('/users/{user}/edit', [AdminuserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminuserController::class, 'update'])->name('admin.users.update');

        
    });

// ======================
// 🚀 STAFF ROUTES
// ======================
Route::prefix('staff')
    ->middleware(['auth', 'role:staff'])
    ->group(function () {
        Route::get('/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');
        Route::get('/staff/surat/cetak', [StaffSuratController::class, 'cetak'])->name('staff.surat.cetak');

        // Surat Masuk & Keluar untuk Staff
        Route::get('/surat-masuk', [StaffSuratController::class, 'indexMasuk'])->name('staff.surat.masuk');
        Route::get('/surat-keluar', [StaffSuratController::class, 'indexKeluar'])->name('staff.surat.keluar');

        // Staff hanya bisa menambah surat, tidak bisa menghapus
        Route::get('/surat/create', [StaffSuratController::class, 'create'])->name('staff.surat.create');
        Route::post('/surat/store', [StaffSuratController::class, 'store'])->name('staff.surat.store');
        Route::get('/surat/{surat}/edit', [StaffSuratController::class, 'edit'])->name('staff.surat.edit');
        Route::put('/surat/{surat}', [StaffSuratController::class, 'update'])->name('staff.surat.update');


        // CRUD Agenda Acara untuk Staff (Hanya Create & Read)
        Route::get('/agenda', [StaffAgendaController::class, 'index'])->name('staff.agenda.index');
        Route::get('/agenda/create', [StaffAgendaController::class, 'create'])->name('staff.agenda.create');
        Route::post('/agenda/store', [StaffAgendaController::class, 'store'])->name('staff.agenda.store');
        Route::get('/agenda/{agenda}/edit', [StaffAgendaController::class, 'edit'])->name('staff.agenda.edit');
        Route::put('/agenda/{agenda}', [StaffAgendaController::class, 'update'])->name('staff.agenda.update');

    });


    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });
    

    

