<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\PenjualanController;
use App\Models\Penjualan;
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


Route::get('/', [BarangController::class, "index"]);
Route::delete('barang/{barang}', [BarangController::class, "delete"]);
Route::post('barang', [BarangController::class, "upsert"]);

Route::get('/penjualan', [PenjualanController::class, "index"]);
Route::delete('penjualan/{penjualan}', [PenjualanController::class, "delete"]);
Route::post('penjualan', [PenjualanController::class, "upsert"]);
