<?php

use App\Http\Controllers\dasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
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
Route::get('/login', [UserController::class, 'loginView'])->name('login');
Route::post('/login', [UserController::class, 'check_login'])->name('login.check_login');

Route::get('/register', [UserController::class, 'registerView'])->name('register.index');
Route::post('/register', [UserController::class, 'store'])->name('register.store');

Route::middleware(['auth'])->group(function () {
Route::get('/logout', [dasController::class, 'logout'])->name('dashboard.logout');
Route::get('/', [dasController::class, 'index'])->name('das');

// Route::resource('kelas', KelasController::class);
Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');       
Route::get('/data', [KelasController::class, 'data'])->name('kelas.data'); 
Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');   
Route::get('/kelas/{id}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update'); 
Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy'); 


Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
Route::get('/guru/{id}', [GuruController::class, 'show'])->name('guru.show');
Route::post('/guru', [GuruController::class, 'store'])->name('guru.store');
Route::put('/guru/{id}', [GuruController::class, 'update'])->name('guru.update');
Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');
Route::get('/kelassss', [GuruController::class, 'getKelas'])->name('guru.getKelas');

Route::get('/kelassss', [SiswaController::class, 'getKelas']);
Route::get('/gurusss', [SiswaController::class, 'getGuru']);

Route::get('/siswa/data', [SiswaController::class, 'index']);
Route::post('/siswa/store', [SiswaController::class, 'store']);
Route::get('/siswa/data/{id}', [SiswaController::class, 'show']);
Route::post('/siswa/update/{id}', [SiswaController::class, 'update']);
Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy']);
});

