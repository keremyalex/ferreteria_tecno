<?php

use App\Http\Controllers\CarritoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Productos
Route::get('/productos', [ProductoController::class, 'index'])->middleware(['auth'])->name('productos.index');
Route::get('/productos/create', [ProductoController::class, 'create'])->middleware(['auth'])->name('productos.create');
Route::post('/productos', [ProductoController::class, 'store'])->middleware(['auth'])->name('productos.store');
Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->middleware(['auth'])->name('productos.edit');
Route::put('/productos/{producto}', [ProductoController::class, 'update'])->middleware(['auth'])->name('productos.update');
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->middleware(['auth'])->name('productos.destroy');
Route::get('/productos/{producto}', [ProductoController::class, 'show'])->middleware(['auth'])->name('productos.show');


Route::get('/carrito', [CarritoController::class, 'index'])->middleware(['auth'])->name('carrito.index');
Route::post('/carrito', [CarritoController::class, 'store'])->middleware(['auth'])->name('carrito.store');
Route::delete('/carrito/{detalle}',[CarritoController::class, 'destroy'])->middleware(['auth'])->name('carrito.destroy');