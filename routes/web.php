<?php

use App\Http\Controllers\{
    DashboardController,
    DosenController,
    KelasController,
    MahasiswaController,
    MatakuliahController
};
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
    return view('auth.login');
});

Route::group([
    'middleware' => ['auth','role:admin,mahasiswa'],
], function () {
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');

    Route::group([
        'middleware' => 'role:admin'
    ], function () {
        Route::get('kelas/data',[KelasController::class,'data'])->name('kelas.data');
        Route::resource('kelas',KelasController::class);

        Route::get('matakuliah/data',[MatakuliahController::class,'data'])->name('matakuliah.data');
        Route::get('matakuliah/data-search',[MatakuliahController::class,'search'])->name('matakuliah.dosen');
        Route::resource('matakuliah',MatakuliahController::class);

        Route::get('mahasiswa/data',[MahasiswaController::class,'data'])->name('mahasiswa.data');
        Route::resource('mahasiswa',MahasiswaController::class);

        Route::get('dosen/data',[DosenController::class,'data'])->name('dosen.data');
        Route::get('dosen/{id}/detail',[DosenController::class,'detail'])->name('dosen.detail');
        Route::resource('dosen',DosenController::class);
    });
});

