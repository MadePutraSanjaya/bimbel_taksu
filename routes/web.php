<?php

use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth', 'prefix' => '/download'], function () {
    Route::get('/download/mata-pembelajaran/{id}', [DownloadController::class, 'mataPembelajaranTemplate'])
    ->name('download.mata-pembelajaran-template');

});
