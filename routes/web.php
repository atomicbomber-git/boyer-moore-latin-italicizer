<?php

use App\Http\Controllers\DokumenController;
use App\Http\Controllers\DokumenDownloadController;
use App\Http\Controllers\KataController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', fn() => redirect()->route("login"));

Auth::routes([
    "register" => false,
    "reset" => false,
    "confirm" => false,
    "verify" => false,
]);

Route::resource("kata", KataController::class)->parameter("kata", "kata");
Route::resource("dokumen", DokumenController::class)->parameter("dokumen", "dokumen");
Route::get("dokumen/{dokumen}/download", DokumenDownloadController::class)->name("dokumen.download");
