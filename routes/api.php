<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiDocumentController;

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

Route::group(['middleware' => 'api.key:PRODUCER'], function () {
    Route::get('/v1/ping', function(Request $request) {
        return response()->json(['message' => 'pong']);
    });

    Route::post('/v1/upload', [ApiDocumentController::class, 'upload']);
});

Route::group(['middleware' => 'api.key:VERIFIER'], function () {
    Route::get('/v1/accept/{document}', [ApiDocumentController::class, 'accept']);
    Route::get('/v1/reject/{document}', [ApiDocumentController::class, 'reject']);
    Route::post('/v1/sign/{document}', [ApiDocumentController::class, 'sign']);
});

Route::group(['middleware' => 'api.key:USER'], function () {
    Route::get('/v1/getDocuments', [ApiDocumentController::class, 'getDocuments']);
    Route::get('/v1/getDeclarations', [ApiDocumentController::class, 'getDeclarations']);

    Route::post('/v1/publish', [ApiDocumentController::class, 'publish']);
    Route::post('/v1/edit/{declaration}', [ApiDocumentController::class, 'edit']);
    Route::get('/v1/delete/{declaration}', [ApiDocumentController::class, 'delete']);
});