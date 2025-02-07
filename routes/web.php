<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiToadController;
use App\Http\Controllers\FilmController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



route::get('/films', function() {
    return view('films');
})->middleware(['auth', 'verified'])->name('films');

Route::get('/films', [ApiToadController::class, 'ApiToad'])->name('films');



route::get('/catalogue',function() {
    return view('catalogue');
})->middleware(['auth', 'verified'])->name('catalogue');

route::get('/catalogue', function() {
    return (new ApiToadController)->ApiToad('catalogue');
})->name('catalogue');

route ::get('/catalogue', [ApiToadController::class, 'ApiToad'])->name('catalogue');

route::get('/linReg', function() {
    return view('linReg');
})->middleware(['auth', 'verified'])->name('linReg');

Route::post('/films/add', [FilmController::class, 'store'])->name('films.add');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
