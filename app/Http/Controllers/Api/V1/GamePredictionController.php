<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\GamePredictionFilter;
use App\Http\Controllers\ApiController;
use App\Http\Requests\UpdateGamePredictionRequest;
use App\Http\Requests\V1\StoreGamePredictionRequest;
use App\Http\Resources\V1\GamePredictionCollection;
use App\Http\Resources\V1\GamePredictionResource;
use App\Models\Game;
use App\Models\GamePrediction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class GamePredictionController extends ApiController {
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request): GamePredictionCollection {
		$filter = new GamePredictionFilter();
		$query = GamePrediction::query();

		$query = $query->with('user');
		$query = $query->with('game')
			->with('game.homeTeam')
			->with('game.awayTeam');

		$queryItems = $filter->transform($request);

		if (count($queryItems) === 0) {
			return new GamePredictionCollection($query->paginate());
		}

		foreach ($queryItems as $item) {
			$query = match ($item[1]) {
				'LIKE' => $query->whereRaw("LOWER($item[0]) LIKE ?", ['%' . strtolower($item[2]) . '%']),
				'IN' => $query->whereIn($item[0], $item[2]),
				default => $query->where($item[0], $item[1], $item[2])
			};
		}

		return new GamePredictionCollection($query->paginate()->appends($request->query()));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreGamePredictionRequest $request): JsonResponse
	{
		$filtered = Arr::except($request->all(), [
			'game',
			'homeGoals',
			'awayGoals',
			'homePenaltyGoals',
			'awayPenaltyGoals'
		]);

		$game = Game::find($filtered['game_id']);

		if ($game->is_knockout && ($filtered['home_penalty_goals'] === $filtered['away_penalty_goals'])) {
				return response()->json([
					'message' => 'Since this is a knockout game, you need to have different goals for home and away team in penalty shootout'
				], 400);
		}

		$gamePrediction = GamePrediction::where('user_id', $filtered['user_id'])
			->where('game_id', $filtered['game_id'])
			->first();

		if (!is_null($gamePrediction) &&
			$gamePrediction->home_goals === $filtered['home_goals'] &&
			$gamePrediction->away_goals === $filtered['away_goals'] &&
			$gamePrediction->home_penalty_goals === $filtered['home_penalty_goals'] &&
			$gamePrediction->away_penalty_goals === $filtered['away_penalty_goals']
		) {
			return response()->json(new GamePredictionResource($gamePrediction));
		}

		if ($gamePrediction) {
			$gamePrediction->delete();
		}

		return response()->json(new GamePredictionResource(GamePrediction::create($filtered)));
	}

	/**
	 * Display the specified resource.
	 */
	public function show(int $gameId): JsonResponse|GamePredictionResource
	{
		$gamePrediction = GamePrediction::where('game_id', $gameId)
			->where('user_id', auth()->id())
			->first();

		if (!$gamePrediction) {
			return response()->json([
				'data' => [],
			]);
		}

		return new GamePredictionResource($gamePrediction);

	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(GamePrediction $gamePrediction) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateGamePredictionRequest $request, GamePrediction $gamePrediction) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(GamePrediction $gamePrediction) {
		//
	}
}
