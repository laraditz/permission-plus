<?php

use Illuminate\Support\Facades\Route;
use Laraditz\PermissionPlus\Http\Controllers\PermissionController;

Route::prefix('permissions')->name('permissions.')->middleware('permission.plus')->group(function () {
    Route::post('/generate', [PermissionController::class, 'generate'])->name('generate');
});

Route::resource('permissions', PermissionController::class)->middleware('permission.plus');
