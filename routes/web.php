<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\LoginController@index')->name('login');
Route::post('/login', 'App\Http\Controllers\LoginController@store');
Route::get('/logout', function(){
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('dashboard',\App\Http\Controllers\Admin\Dashboard\DashboardController::class)->only('index');

    Route::middleware(['isAdmin'])->group(function () {
        Route::resource('master-data/region',\App\Http\Controllers\Admin\MasterData\Region\RegionController::class)->except('show');
        Route::resource('master-data/kantor',\App\Http\Controllers\Admin\MasterData\Kantor\KantorController::class)->except('show');
        Route::resource('master-data/tambang',\App\Http\Controllers\Admin\MasterData\Tambang\TambangController::class)->except('show');
        Route::resource('master-data/kendaraan',\App\Http\Controllers\Admin\MasterData\Kendaraan\KendaraanController::class)->except('show');
        Route::get('master-data/kendaraan-pemesanan-avilable', 'App\Http\Controllers\Admin\MasterData\Kendaraan\KendaraanController@pemesananKendaraanAvailable');
        Route::resource('master-data/pegawai',\App\Http\Controllers\Admin\MasterData\Pegawai\PegawaiController::class)->except('show');
        Route::get('master-data/pegawai-driver-pemesanan-avilable', 'App\Http\Controllers\Admin\MasterData\Pegawai\PegawaiController@pemesananDriverAvailable');
    });
    Route::resource('pemesanan',\App\Http\Controllers\Admin\Pemesanan\PemesananController::class)->except('show');
    Route::resource('jadwal-service',\App\Http\Controllers\Admin\JadwalService\JadwalServiceController::class)->except('show');
    Route::resource('konsumsi-bbm',\App\Http\Controllers\Admin\KonsumsiBbm\KonsumsiBbmController::class)->except('show');
});
