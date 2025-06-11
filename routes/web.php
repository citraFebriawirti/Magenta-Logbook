<?php

use App\Http\Controllers\Auth\AuthController;
use App\Livewire\Pesertas;
use App\Livewire\Mentors;
use App\Livewire\Dashboard;
use App\Livewire\Kegiatans;
use App\Livewire\UnitKerja;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth', 'verified'])->group(function () {});

// Rute untuk pengguna yang belum login
Route::middleware('belum_login')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('home');
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});


// Rute untuk pengguna yang sudah login
Route::middleware('sudah_login')->group(function () {
    Route::middleware(['auth', 'role:admin'])->group(function () {



        Route::get('/admin-dashboard', Dashboard::class)->name('admin-dashboard');
        Route::get('/unit-kerja', UnitKerja::class)->name('unit-kerja');
        Route::get('/mentor', Mentors::class)->name('mentor');
        Route::get('/peserta', Pesertas::class)->name('peserta');
        Route::get('/kegiatan', Kegiatans::class)->name('kegiatan');
    });



    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});