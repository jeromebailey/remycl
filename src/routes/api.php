<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/////////////// PATIENT ////////////////
//Route::prefix('/patient')->group(function () {
    Route::post('/patient/readings/bp', [App\Http\Controllers\ReadingController::class, 'patientsBPReadings'])->name('patient/readings/bp');
    Route::post('/patient/readings/bg', [App\Http\Controllers\ReadingController::class, 'patientsBGReadings'])->name('patient/readings/bg');
//     Route::post('/readings/bg', [App\Http\Controllers\PatientController::class, 'patientsBGReadings'])->name('patient/readings/bg');
// });

// Route::post('/send-security-code', [ApplicationController::class, 'send_security_code'])->name('api/send-security-code');

// Route::post('/verify-security-code', [ApplicationController::class, 'verify_security_code'])->name('api/verify-security-code');