<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiToadController;
use App\Http\Controllers\authController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\inventoryController;

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

Route::get('/inventaire', [inventoryController::class, 'getInventory'])->name('inventory.getInventory');

// POST pour ajouter un film en stock
Route::post('/inventaire/add', [InventoryController::class, 'storeInventory'])
     ->name('inventory.store');

// POST pour supprimer des films du stock
Route::post('/inventaire/delete', [InventoryController::class, 'deleteInventory'])
     ->name('inventory.delete');

Route::get('/films/data/{id}', [FilmController::class, 'getFilmData'])
     ->name('films.data');

route::get('/linReg', function() {
    return view('linReg');
});

Route::post('/films/add', [FilmController::class, 'store'])->name('films.add');
Route::post('/films/delete', [FilmController::class, 'deleteFilm'])->name('films.delete');
Route::post('/films/update', [FilmController::class, 'UpdateFilm'])->name('films.update');

