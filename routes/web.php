<?php

use App\Http\Controllers\AnprEventController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AnprEventController::class, 'index'])->name('anpr.index');
