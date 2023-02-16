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

Route::get('/', 'App\Http\Controllers\LoginController@index');
Route::post('/login', 'App\Http\Controllers\LoginController@store');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('dashboard',\App\Http\Controllers\Admin\Dashboard\DashboardController::class)->only('index');

    Route::resource('master-data/region',\App\Http\Controllers\Admin\MasterData\Region\RegionController::class)->except('show');
    Route::resource('master-data/kantor',\App\Http\Controllers\Admin\MasterData\Kantor\KantorController::class)->except('show');
    Route::resource('master-data/tambang',\App\Http\Controllers\Admin\MasterData\Tambang\TambangController::class)->except('show');
});
