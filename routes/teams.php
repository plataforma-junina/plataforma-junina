<?php

declare(strict_types=1);

use App\Http\Controllers\Teams\TeamController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('teams/create', [TeamController::class, 'store'])->name('teams.store');
});
