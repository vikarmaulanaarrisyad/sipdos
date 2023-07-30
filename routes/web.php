<?php

use App\Http\Controllers\{
    DashboardController,
    DosenController,
    KelasController,
    KuisionerController,
    MahasiswaController,
    MahasiswaKuisioner,
    MatakuliahController,
    ReportController,
    UserProfileInformationController
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
    'middleware' => ['auth', 'role:admin,mahasiswa'],
], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/user/profile/password', [UserProfileInformationController::class, 'showPassword'])
        ->name('profile.show.password');

    Route::group([
        'middleware' => 'role:admin'
    ], function () {
        Route::get('kelas/data', [KelasController::class, 'data'])->name('kelas.data');
        Route::resource('kelas', KelasController::class);

        Route::get('matakuliah/data', [MatakuliahController::class, 'data'])->name('matakuliah.data');
        Route::get('matakuliah/data-search', [MatakuliahController::class, 'search'])->name('matakuliah.dosen');
        Route::resource('matakuliah', MatakuliahController::class);

        Route::get('mahasiswa/data', [MahasiswaController::class, 'data'])->name('mahasiswa.data');
        Route::resource('mahasiswa', MahasiswaController::class);

        Route::get('dosen/data', [DosenController::class, 'data'])->name('dosen.data');
        Route::get('dosen/{id}/detail', [DosenController::class, 'detail'])->name('dosen.detail');
        Route::post('dosen/matakuliah/store', [DosenController::class, 'dosenMatakuliahStore'])->name('dosen.matakuliah.store');
        Route::get('dosen/{dosen}/matakuliah/data', [DosenController::class, 'matakuliahData'])->name('dosen.matakuliah.data');
        Route::get('dosen/{dosen_id}/matakuliah', [DosenController::class, 'getDosenMatakuliah'])->name('dosen.matakuliah');
        Route::delete('dosen/matakuliah/{matakuliah_id}/destroy', [DosenController::class, 'matakuliahDestroy'])->name('dosen.matakuliah_destroy');
        Route::resource('dosen', DosenController::class);

        Route::get('kuisioner/data', [KuisionerController::class, 'data'])->name('kuisioner.data');
        Route::resource('kuisioner', KuisionerController::class);

        Route::get('report/data',[ReportController::class,'data'])->name('report.data');
        Route::get('report',[ReportController::class,'index'])->name('report.index');
    });

    Route::group([
        'middleware' => 'role:mahasiswa',
    ], function () {
        Route::get('quis/data', [MahasiswaKuisioner::class, 'data'])->name('quis.data');
        Route::resource('quis', MahasiswaKuisioner::class);
    });
});
