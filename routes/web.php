<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('aboutus', function(){
    return  view('aboutus');
})->name('aboutus');

Route::get('ourlocales', [LocalController::class, 'index'])->name('ourlocales');
Route::get('ourlocales/{id}', [LocalController::class, 'localView'])->name('ourlocales.show');




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/local', [LocalController::class, 'store'])->name('local.store');

    Route::put('/reserva/cancelar/{id}', [DashboardController::class, 'cancelar'])->name('reserva.cancelar');
    
});


