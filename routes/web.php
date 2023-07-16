<?php

use App\Http\Controllers\{
    DashboardController,
    KelasController
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
    });
});

