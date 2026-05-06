<?php

use App\Http\Controllers\CotoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ResidenteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cotos
    Route::resource('cotos', CotoController::class);

    // Residentes
    Route::resource('residentes', ResidenteController::class);

    // Pagos
    Route::resource('pagos', PagoController::class);
    Route::get('/adeudos', [PagoController::class, 'adeudos'])->name('pagos.adeudos');

    // Reportes
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('index');
        Route::get('/pagos', [ReporteController::class, 'pagos'])->name('pagos');
        Route::get('/adeudos', [ReporteController::class, 'adeudos'])->name('adeudos');
        Route::get('/financiero', [ReporteController::class, 'financiero'])->name('financiero');
    });

    // Perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
