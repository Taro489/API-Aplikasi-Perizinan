<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UsereditController;
use App\Http\Controllers\Api\PermittionController;
use App\Http\Controllers\Api\AcceptPermittionController;
use App\Http\Controllers\Api\PermittionAppliedController;

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

Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'authentication']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/apply/{permittion:id}', [PermittionAppliedController::class, 'applyPermittion']);
    Route::post('/cancel/{permittion:id}', [PermittionAppliedController::class, 'cancelPermittion']);
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/user-updatepass/{user:id}', [UsereditController::class, 'updatePasswordUser']);
    Route::post('/add-verificator', [UsereditController::class, 'addVerificator']);
    Route::post('/accept-permittion', [AcceptPermittionController::class, 'acceptState']);
    Route::put('/promote-verificator', [UsereditController::class, 'promoteToVerificator']);
    Route::put('/verify-user/{user:id}', [UsereditController::class, 'verifiedUserRegister']);
    Route::get('/read-user', [UsereditController::class, 'index']);
    Route::get('/read-permittion', [AcceptPermittionController::class, 'showAllPermittions']);
    Route::resource('/permittion', PermittionController::class);
});



