<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'horarios'])->name('horarios');
Route::get('/calendario', [\App\Http\Controllers\CalendarController::class, 'index'])->name('calendario');
Route::get('/talleres', [PageController::class, 'talleres'])->name('talleres');
Route::get('/carteles', [PageController::class, 'carteles'])->name('carteles');
Route::get('/asociacion', [PageController::class, 'asociacion'])->name('asociacion');
Route::get('/online', [PageController::class, 'online'])->name('online');
Route::get('/mi-camino', [PageController::class, 'camino'])->name('mi-camino');

// Panel de administración.
// TODO: añadir contraseña (middleware de autenticación) antes de pasar a producción.
Route::prefix('palomacano1')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('home');
    Route::get('ajustes', [AdminController::class, 'settings'])->name('settings');
    Route::post('ajustes', [AdminController::class, 'saveSettings'])->name('settings.save');
    Route::get('{key}', [AdminController::class, 'index'])->name('index');
    Route::get('{key}/nuevo', [AdminController::class, 'create'])->name('create');
    Route::post('{key}', [AdminController::class, 'store'])->name('store');
    Route::get('{key}/{id}/editar', [AdminController::class, 'edit'])->name('edit');
    Route::put('{key}/{id}', [AdminController::class, 'update'])->name('update');
    Route::delete('{key}/{id}', [AdminController::class, 'destroy'])->name('destroy');
});
