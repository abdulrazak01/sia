<?php

use Illuminate\Support\Facades\Route;
use App\Models\ResponsesPendaftaran;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Http\Request;
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

Route::get('/daftar-siswa', function () {
    $siswa = ResponsesPendaftaran::with(['programPaket', 'kelas'])
        ->orderBy('submitted_at', 'desc')
        ->get();

    return response()->json($siswa); // atau return view('siswa', compact('siswa'));
});

Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');


Route::get('/', function () {
    return view('pendaftaraan');
});


