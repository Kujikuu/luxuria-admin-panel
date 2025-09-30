<?php

use App\Http\Controllers\Api\BrokerController;
use App\Http\Controllers\Api\ListingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // Listings routes
    Route::get('/listings', [ListingController::class, 'index']);
    Route::get('/listings/{listing}', [ListingController::class, 'show']);

    // Brokers routes
    Route::get('/brokers', [BrokerController::class, 'index']);
    Route::get('/brokers/{broker}', [BrokerController::class, 'show']);
});
