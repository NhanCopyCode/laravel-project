<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\WardController;
use App\Http\Controllers\api\ProvineController;
use App\Http\Controllers\api\DistrictController;
use App\Http\Controllers\admins\BranchController;

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

Route::get('/provine', [ProvineController::class, 'index']);

Route::get('/wards', [WardController::class,'index']);

Route::get('/districts', [DistrictController::class,'index']);

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/responseJson', [AuthController::class, 'responseJson']);