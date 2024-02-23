<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\detailpenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\MenuController;
use Carbon\Carbon;
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

Route::post('/register', 'Auth\RegisterController@register')->name('register');

Route::get('/dashboard', function () {
    $mondayOfLastWeek = Carbon::now()->startOfWeek()->toDateString();

    $sundayOfLastWeek = Carbon::now()->endOfWeek()->toDateString();

    $totalPenjualanPerDay = DB::table('penjualan')
        ->selectRaw('
        SUM(CASE WHEN DAYOFWEEK(TanggalPenjualan) = 2 THEN TotalHarga ELSE 0 END) AS Monday,
        SUM(CASE WHEN DAYOFWEEK(TanggalPenjualan) = 3 THEN TotalHarga ELSE 0 END) AS Tuesday,
        SUM(CASE WHEN DAYOFWEEK(TanggalPenjualan) = 4 THEN TotalHarga ELSE 0 END) AS Wednesday,
        SUM(CASE WHEN DAYOFWEEK(TanggalPenjualan) = 5 THEN TotalHarga ELSE 0 END) AS Thursday,
        SUM(CASE WHEN DAYOFWEEK(TanggalPenjualan) = 6 THEN TotalHarga ELSE 0 END) AS Friday,
        SUM(CASE WHEN DAYOFWEEK(TanggalPenjualan) = 7 THEN TotalHarga ELSE 0 END) AS Saturday,
        SUM(CASE WHEN DAYOFWEEK(TanggalPenjualan) = 1 THEN TotalHarga ELSE 0 END) AS Sunday
    ')
        ->whereDate('TanggalPenjualan', '>=', $mondayOfLastWeek)
        ->whereDate('TanggalPenjualan', '<=', $sundayOfLastWeek)
        ->first();

    $val = [];
    foreach ($totalPenjualanPerDay as $key => $value) {
        $val[] = $value;
    }

    $chartPenjualan = [
        'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        'datasets' => [
            [
                'label' => 'Penjualan',
                'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'borderWidth' => 1,
                'data' => $val,
            ],
        ],
    ];



    return view('dashboard', ['chartPenjualan' => $chartPenjualan]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/user', function () {
    return view('user');
})->middleware(['auth', 'verified', 'checkRole:USER'])->name('user');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('produk')->group(function () {
    Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
    Route::post('/store', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/show/{ProdukID}', [ProdukController::class, 'show'])->name('produk.show');
    Route::patch('/update/{ProdukID}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/destroy/{ProdukID}', [ProdukController::class, 'destroy'])->name('produk.destroy');
});

Route::prefix('detailpenjualan')->group(function () {
    Route::get('/', [detailpenjualanController::class, 'index'])->name('detailpenjualan.index');
    Route::post('/store', [detailpenjualanController::class, 'store'])->name('detailpenjualan.store');
    Route::get('/show/{DetailID}', [detailpenjualanController::class, 'show'])->name('detailpenjualan.show');
    Route::get('/print/{DetailID}', [detailpenjualanController::class, 'printPdf'])->name('detailpenjualan.print');
    Route::delete('/destroy/{DetailID}', [detailpenjualanController::class, 'destroy'])->name('detailpenjualan.destroy');
});

Route::prefix('penjualan')->group(function () {
    Route::get('/', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/show/{PenjualanID}', [PenjualanController::class, 'show'])->name('penjualan.show');
    Route::patch('/update/{PenjualanID}', [PenjualanController::class, 'update'])->name('penjualan.update');
    Route::delete('/destroy/{PenjualanID}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
});

Route::prefix('petugas')->group(function () {
    Route::get('/', [PetugasController::class, 'index'])->name('petugas.index');
    Route::post('/store', [PetugasController::class, 'store'])->name('petugas.store');
    Route::get('/show/{id}', [PetugasController::class, 'show'])->name('petugas.show');
    Route::patch('/update/{id}', [PetugasController::class, 'update'])->name('petugas.update');
    Route::delete('/destroy/{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');
});

Route::prefix('pelanggan')->group(function () {
    Route::get('/', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::post('/store', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/show/{PelangganID}', [PelangganController::class, 'show'])->name('pelanggan.show');
    Route::patch('/update/{PelangganID}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::delete('/destroy/{PelangganID}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
});




require __DIR__ . '/auth.php';
