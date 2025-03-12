<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\GameController;
use App\Http\Controllers\Api\V1\GamePredictionController;
use App\Http\Controllers\Api\V1\GroupController;
use App\Http\Controllers\Api\V1\PlayerController;
use App\Http\Controllers\Api\V1\StatController;
use App\Http\Controllers\Api\V1\StatPredictionController;
use App\Http\Controllers\Api\V1\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
	return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
	Route::post('/register', [AuthController::class, 'register']);
	Route::post('/login', [AuthController::class, 'login']);

	Route::middleware('auth:sanctum')->group(function () {
		Route::post('/logout', [AuthController::class, 'logout']);
		Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
	});
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function () {
	Route::apiResource('groups', GroupController::class);
	Route::apiResource('teams', TeamController::class);
	Route::apiResource('players', PlayerController::class);
	Route::apiResource('games', GameController::class);
	Route::apiResource('stats', StatController::class);
	Route::apiResource('statPredictions', StatPredictionController::class);
	Route::apiResource('gamePredictions', GamePredictionController::class);

	Route::post('players/import', [PlayerController::class, 'import']);
	Route::post('statPredictions/import', [StatPredictionController::class, 'import']);

	Route::get('statTypes', [StatController::class, 'fetchTypes']);
})->middleware('auth:sanctum');
