<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IslandController;
use App\Http\Controllers\Api\SectorController;
use App\Http\Controllers\Api\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Island Portfolio API - مفتوح بدون مصادقة
Route::get('/island', [IslandController::class, 'show']);
Route::post('/island', [IslandController::class, 'createOrUpdate']);

// Sectors API - مفتوح بدون مصادقة
Route::get('/sectors', [SectorController::class, 'index']);
Route::get('/sectors/{id}', [SectorController::class, 'show']);
Route::post('/sectors', [SectorController::class, 'store']);
Route::post('/sectors/{id}', [SectorController::class, 'update']); // POST بدلاً من PUT لدعم رفع الصور
Route::delete('/sectors/{id}', [SectorController::class, 'destroy']);

// Clients API - مفتوح بدون مصادقة
Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store']);
Route::post('/clients/{id}', [ClientController::class, 'update']); // POST لدعم رفع الصور
Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

// Certificates API - مفتوح بدون مصادقة
Route::get('/certificates', [\App\Http\Controllers\Api\CertificateController::class, 'index']);
Route::post('/certificates', [\App\Http\Controllers\Api\CertificateController::class, 'store']);
Route::post('/certificates/{id}', [\App\Http\Controllers\Api\CertificateController::class, 'update']);
Route::delete('/certificates/{id}', [\App\Http\Controllers\Api\CertificateController::class, 'destroy']);
