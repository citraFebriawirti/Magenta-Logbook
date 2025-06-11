<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Livewire\UnitKerja;
use App\Livewire\Mentors;

use App\Livewire\Kegiatans;



Route::prefix('unit_kerja')->group(function () {
    Route::post('/store', [UnitKerja::class, 'apiStore'])->name('api.unit_kerja.store');
    Route::get('/getAll', [UnitKerja::class, 'apiGetAll'])->name('api.unit_kerja.getAll');
    Route::get('/edit/{id}', [UnitKerja::class, 'apiEdit'])->name('api.unit_kerja.edit');
    Route::put('/update/{id}', [UnitKerja::class, 'apiUpdate'])->name('api.unit_kerja.update');
    Route::delete('/delete/{id}', [UnitKerja::class, 'apiDelete'])->name('api.unit_kerja.delete');
});
Route::prefix('mentor')->group(function () {
    Route::post('/store', [Mentors::class, 'apiStore'])->name('api.mentor.store');
    Route::get('/getAll', [Mentors::class, 'apiGetAll'])->name('api.mentor.getAll');
    Route::get('/edit/{id}', [Mentors::class, 'apiGetById'])->name('api.mentor.edit');
    Route::put('/update/{id}', [Mentors::class, 'apiUpdate'])->name('api.mentor.update');
    Route::delete('/delete/{id}', [Mentors::class, 'apiDelete'])->name('api.mentor.delete');
});


Route::prefix('kegiatan')->group(function () {
    Route::post('/store', [Kegiatans::class, 'apiStore'])->name('api.kegiatan.store');
    Route::get('/getAll', [Kegiatans::class, 'apiGetAll'])->name('api.kegiatan.getAll');
    Route::get('/edit/{id}', [Kegiatans::class, 'apiGetById'])->name('api.kegiatan.edit');
    Route::put('/update/{id}', [Kegiatans::class, 'apiUpdate'])->name('api.kegiatan.update');
    Route::delete('/delete/{id}', [Kegiatans::class, 'apiDelete'])->name('api.kegiatan.delete');
});