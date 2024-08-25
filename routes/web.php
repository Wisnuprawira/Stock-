<?php

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


Route::get('/login', [App\Http\Controllers\AuthController::class, 'loginPage'])->name('loginPage');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'registerPage'])->name('registerPage');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard.index');
    });
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
    
    Route::group(['prefix' => 'kriteria'], function () {
        Route::get('/', [App\Http\Controllers\KriteriaController::class, 'index'])->name('kriteria.index');
        Route::get('/create-kriteria', [App\Http\Controllers\KriteriaController::class, 'createPages'])->name('kriteria.createPages');
        Route::post('/create-kriteria', [App\Http\Controllers\KriteriaController::class, 'create'])->name('kriteria.create');
    
        Route::get('/edit-kriteria/{id}', [App\Http\Controllers\KriteriaController::class, 'editPages'])->name('kriteria.editPages');
        Route::post('/edit-kriteria/{id}', [App\Http\Controllers\KriteriaController::class, 'edit'])->name('kriteria.edit');
    
        Route::get('/hapus-kriteria/{id}', [App\Http\Controllers\KriteriaController::class, 'delete'])->name('kriteria.delete'); 
    });
    
    Route::group(['prefix' => 'kriteria-sub'], function () {
        Route::get('/', [App\Http\Controllers\SubKriteriaController::class, 'index'])->name('sub.kriteria.index');
        
        Route::get('/create-sub-kriteria', [App\Http\Controllers\SubKriteriaController::class, 'createPages'])->name('sub.kriteria.createPages');
        Route::post('/create-sub-kriteria', [App\Http\Controllers\SubKriteriaController::class, 'create'])->name('sub.kriteria.create');
    
        Route::get('/edit-sub-kriteria/{id}', [App\Http\Controllers\SubKriteriaController::class, 'editPages'])->name('sub.kriteria.editPages');
        Route::post('/edit-sub-kriteria/{id}', [App\Http\Controllers\SubKriteriaController::class, 'edit'])->name('sub.kriteria.edit');
    
        Route::get('/hapus-sub-kriteria/{id}', [App\Http\Controllers\SubKriteriaController::class, 'delete'])->name('sub.kriteria.delete'); 
    });
    
    Route::group(['prefix' => 'hitung'], function () {
        Route::group(['prefix' => 'kriteria'], function () {
            Route::get('/', [App\Http\Controllers\CalculateController::class, 'index'])->name('hitung.index');
            Route::post('/hitung', [App\Http\Controllers\CalculateController::class, 'hitung'])->name('hitung.create');
            Route::get('/reset', [App\Http\Controllers\CalculateController::class, 'reset'])->name('hitung.reset');
        }); 
    
        Route::group(['prefix' => 'sub-kriteria'], function () {
            Route::get('/{id}', [App\Http\Controllers\CalculateController::class, 'indexSub'])->name('sub-hitung.index');
            Route::post('/hitung', [App\Http\Controllers\CalculateController::class, 'hitungSub'])->name('sub-hitung.create');
            Route::get('/reset/{id}', [App\Http\Controllers\CalculateController::class, 'resetSub'])->name('sub-hitung.reset');
        }); 
        Route::group(['prefix' => 'alternatif'], function () {
            Route::get('/', [App\Http\Controllers\AlternatifController::class, 'index'])->name('alternatif.index');
            Route::get('/create-alternatif', [App\Http\Controllers\AlternatifController::class, 'createPages'])->name('alternatif.createPages');
            Route::post('/create-alternatif', [App\Http\Controllers\AlternatifController::class, 'create'])->name('alternatif.create');
    
            Route::get('/edit-alternaitf/{id}', [App\Http\Controllers\AlternatifController::class, 'editPages'])->name('alternatif.editPages');
            // Route::post('/edit-alternaitf/{id}', [App\Http\Controllers\AlternatifController::class, 'edit'])->name('alternatif.edit');
    
            Route::get('/hapus/{id}', [App\Http\Controllers\AlternatifController::class, 'delete'])->name('alternatif.delete'); 
        });
        
    });  

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [App\Http\Controllers\AuthController::class, 'getUser'])->name('user.index');
        Route::get('/create-user', [App\Http\Controllers\AuthController::class, 'createPages'])->name('user.createPages');
        Route::post('/create-user', [App\Http\Controllers\AuthController::class, 'create'])->name('user.create');

        Route::get('/edit-user/{id}', [App\Http\Controllers\AuthController::class, 'editPages'])->name('user.editPages');
        Route::post('/edit-user/{id}', [App\Http\Controllers\AuthController::class, 'edit'])->name('user.edit');

        Route::get('/hapus-user/{id}', [App\Http\Controllers\AuthController::class, 'delete'])->name('user.delete'); 
    });
});
