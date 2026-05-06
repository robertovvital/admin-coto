<?php

use App\Http\Controllers\Api\CountryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - REST Countries Integration
|--------------------------------------------------------------------------
*/
Route::prefix('countries')->name('api.countries.')->group(function () {
    Route::get('/', [CountryController::class, 'index'])->name('index');
    Route::get('/{codigo}', [CountryController::class, 'show'])->name('show');
});
