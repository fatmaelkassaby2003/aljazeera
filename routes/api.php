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

// Work Methods API - كيف ندير عملنا
Route::get('/work-methods', [\App\Http\Controllers\Api\WorkMethodController::class, 'index']);
Route::get('/work-methods/{id}', [\App\Http\Controllers\Api\WorkMethodController::class, 'show']);
Route::post('/work-methods', [\App\Http\Controllers\Api\WorkMethodController::class, 'store']);
Route::post('/work-methods/{id}', [\App\Http\Controllers\Api\WorkMethodController::class, 'update']);
Route::delete('/work-methods/{id}', [\App\Http\Controllers\Api\WorkMethodController::class, 'destroy']);

// About Us Routes
Route::get('/about-us', [App\Http\Controllers\Api\AboutUsController::class, 'index']);
Route::post('/about-us', [App\Http\Controllers\Api\AboutUsController::class, 'store']);

// Financial Services Routes
Route::get('/financial-services', [App\Http\Controllers\Api\FinancialServiceController::class, 'index']);
Route::get('/financial-services/{id}', [App\Http\Controllers\Api\FinancialServiceController::class, 'show']);
Route::post('/financial-services', [App\Http\Controllers\Api\FinancialServiceController::class, 'store']);
Route::post('/financial-services/{id}', [App\Http\Controllers\Api\FinancialServiceController::class, 'update']);
Route::delete('/financial-services/{id}', [App\Http\Controllers\Api\FinancialServiceController::class, 'destroy']);

// Integration Services Routes
Route::get('/integration-services', [App\Http\Controllers\Api\IntegrationServiceController::class, 'index']);
Route::get('/integration-services/{id}', [App\Http\Controllers\Api\IntegrationServiceController::class, 'show']);
Route::post('/integration-services', [App\Http\Controllers\Api\IntegrationServiceController::class, 'store']);
Route::post('/integration-services/{id}', [App\Http\Controllers\Api\IntegrationServiceController::class, 'update']);
Route::delete('/integration-services/{id}', [App\Http\Controllers\Api\IntegrationServiceController::class, 'destroy']);

// Facility Services Routes
Route::get('/facility-services', [App\Http\Controllers\Api\FacilityServiceController::class, 'index']);
Route::get('/facility-services/{id}', [App\Http\Controllers\Api\FacilityServiceController::class, 'show']);
Route::post('/facility-services', [App\Http\Controllers\Api\FacilityServiceController::class, 'store']);
Route::post('/facility-services/{id}', [App\Http\Controllers\Api\FacilityServiceController::class, 'update']);
Route::delete('/facility-services/{id}', [App\Http\Controllers\Api\FacilityServiceController::class, 'destroy']);

// Quote Requests Routes
Route::post('/quote-requests', [App\Http\Controllers\Api\QuoteRequestController::class, 'store']);
Route::get('/quote-requests', [App\Http\Controllers\Api\QuoteRequestController::class, 'index']);
Route::get('/quote-requests/{id}', [App\Http\Controllers\Api\QuoteRequestController::class, 'show']);

// Contact Messages Routes
Route::post('/contact-messages', [App\Http\Controllers\Api\ContactMessageController::class, 'store']);
Route::get('/contact-messages', [App\Http\Controllers\Api\ContactMessageController::class, 'index']);
Route::get('/contact-messages/{id}', [App\Http\Controllers\Api\ContactMessageController::class, 'show']);

// Newsletter Subscription Routes
Route::post('/newsletter/subscribe', [App\Http\Controllers\Api\NewsletterSubscriptionController::class, 'subscribe']);
Route::get('/newsletter/subscriptions', [App\Http\Controllers\Api\NewsletterSubscriptionController::class, 'index']);

// Contact Info Routes
Route::get('/contact-info', [App\Http\Controllers\Api\ContactInfoController::class, 'index']);
Route::post('/contact-info', [App\Http\Controllers\Api\ContactInfoController::class, 'store']);

// Budget Ranges Routes
Route::get('/budget-ranges', [App\Http\Controllers\Api\BudgetRangeController::class, 'index']);




