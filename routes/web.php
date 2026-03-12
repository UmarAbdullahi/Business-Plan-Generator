<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessPlanController;

Route::get('/', [BusinessPlanController::class, 'index'])->name('home');
Route::post('/generate', [BusinessPlanController::class, 'generate'])->name('generate');
Route::get('/preview', [BusinessPlanController::class, 'preview'])->name('preview');
Route::post('/export-pdf', [BusinessPlanController::class, 'exportPdf'])->name('export.pdf');
