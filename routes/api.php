<?php

use App\Http\Controllers\Api\V1\GameController;
use App\Http\Controllers\Api\V1\GroupController;
use App\Http\Controllers\Api\V1\PlayerController;
use App\Http\Controllers\Api\V1\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
		Route::apiResource('groups', GroupController::class);
		Route::apiResource('teams', TeamController::class);
		Route::apiResource('players', PlayerController::class);
		Route::apiResource('games', GameController::class);
});
