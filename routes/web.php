<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiToadController;
use App\Http\Controllers\authController;
use App\Http\Controllers\FilmController;

// Route::get('/dashboard', function () {
    // return view('dashboard');
// });

route::get('/films', function() {
    return view('films');
});

Route::get('/films', [ApiToadController::class, 'ApiToad'])->name('films');

Route::get('/', function () {
    return view('login_staff');
});
Route::post('/login_staff', [authController::class, 'login'])->name('login_staff');

route::get('/catalogue',function() {
    return view('catalogue');
});


Route::get  ('/films/edit',   [FilmController::class, 'edit'])->name('films.edit');
Route::post ('/films/update', [FilmController::class, 'updateFilm'])->name('films.update');


route::get('/catalogue', function() {
    return (new ApiToadController)->ApiToad('catalogue');
})->name('catalogue');

route ::get('/catalogue', [ApiToadController::class, 'ApiToad'])->name('catalogue');

route::get('/linReg', function() {
    return view('linReg');
});

Route::post('/films/add', [FilmController::class, 'store'])->name('films.add');
Route::post('/films/delete', [FilmController::class, 'deleteFilm'])->name('films.delete');
Route::post('/films/update', [FilmController::class, 'UpdateFilm'])->name('films.update');

