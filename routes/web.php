<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\JenisSuratController;
use App\Http\Controllers\Transaction\SuratController;
use App\Http\Controllers\Auth\AuthController;

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
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.process');

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    

    Route::prefix('master/jenis-surat')->name('master.jenis_surat.')->group(function () {
        Route::get('/', [JenisSuratController::class, 'index'])->name('index');
        Route::get('/get-data', [JenisSuratController::class, 'getData'])->name('get_data');
        Route::get('/add', [JenisSuratController::class, 'addData'])->name('add');
        Route::post('/create', [JenisSuratController::class, 'createData'])->name('create');
        Route::get('/edit/{id}', [JenisSuratController::class, 'editData'])->name('edit');
        Route::post('/update/{id}', [JenisSuratController::class, 'updateData'])->name('update');
        Route::get('/detail/{id}', [JenisSuratController::class, 'detailData'])->name('detail');
        Route::match(['get', 'post'], '/delete/{id}', [JenisSuratController::class, 'deleteData'])->name('delete');
    });

    Route::prefix('transaction/surat')->name('transaction.surat.')->group(function () {
        Route::get('/', [SuratController::class, 'index'])->name('index');
        Route::get('/get-data', [SuratController::class, 'getData'])->name('get_data');
        Route::get('/add', [SuratController::class, 'addData'])->name('add');
        Route::post('/create', [SuratController::class, 'createData'])->name('create');
        Route::get('/edit/{id}', [SuratController::class, 'editData'])->name('edit');
        Route::post('/update/{id}', [SuratController::class, 'updateData'])->name('update');
        Route::get('/detail/{id}', [SuratController::class, 'detailData'])->name('detail');
        Route::match(['get', 'post'], '/delete/{id}', [SuratController::class, 'deleteData'])->name('delete');
    });
});
