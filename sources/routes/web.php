<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Office\PermissionsController;
use App\Http\Controllers\Office\PosttypeController;
use App\Http\Controllers\Office\StructionPagesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return view('welcome');
});

Route::prefix('/office')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::prefix('/permissions')->group(function () {
            Route::post('/register', [RegisteredUserController::class, 'store'])->name('permissions.register_post');
            Route::get('/register', [RegisteredUserController::class, 'create'])->name('permissions.register');
        });
    });

    Route::get('/single_detail/{id}', [StructionPagesController::class, 'singleShow'])->name('structionpages.single_detail');
    Route::get('/single_edit/{id}', [StructionPagesController::class, 'singleEdit'])->name('structionpages.single_edit');
    Route::post('/single_update/{id}', [StructionPagesController::class, 'singleUpdate'])->name('structionpages.single_update');
});

require __DIR__.'/auth.php';
