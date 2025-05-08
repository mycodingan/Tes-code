<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
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

Route::get('/', function () {
    return view('layout.master');
});

// Route::resource('kelas', KelasController::class);
Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');       
Route::get('/data', [KelasController::class, 'data'])->name('kelas.data'); 
Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');   
Route::get('/kelas/{id}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update'); 
Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy'); 

Route::get('/guru', [GuruController::class, 'index']);
Route::post('/guru', [GuruController::class, 'store']);
Route::get('/guru/{id}', [GuruController::class, 'show']);
Route::put('/guru/{id}', [GuruController::class, 'update']);
Route::delete('/guru/{id}', [GuruController::class, 'destroy']);
Route::get('/kelas', [GuruController::class, 'getKelas']); 