<?php

use App\Livewire\Mentors;
use App\Livewire\Dashboard;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {});



Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/unit-kerja', UnitKerja::class)->name('unit-kerja');
Route::get('/mentor', Mentors::class)->name('mentor');
