<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\StatPredictionFilter;
use App\Http\Controllers\ApiController;
use App\Http\Requests\UpdateStatPredictionRequest;
use App\Http\Requests\V1\ImportStatPredictionRequest;
use App\Http\Requests\V1\StoreStatPredictionRequest;
use App\Http\Resources\V1\StatPredictionCollection;
use App\Http\Resources\V1\StatPredictionResource;
use App\Models\StatPrediction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class StatPredictionController extends ApiController {
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request): StatPredictionCollection {
		$filter = new StatPredictionFilter();
		$query = StatPrediction::query();

		$query = $query->with('user');
		$query = $query->with('game');
		$query = $query->with('player');

		$queryItems = $filter->transform($request);

		if (count($queryItems) === 0) {
			return new StatPredictionCollection($query->paginate());
		}

		foreach ($queryItems as $item) {
			$query = match ($item[1]) {
				'LIKE' => $query->where($item[0], 'LIKE', $item[2]),
				'IN' => $query->whereIn($item[0], $item[2]),
				default => $query->where($item[0], $item[1], $item[2])
			};
		}

		return new StatPredictionCollection($query->paginate()->appends($request->query()));
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
	public function store(StoreStatPredictionRequest $request): StatPredictionResource|JsonResponse
	{
		try {
			$predictionsCount = StatPrediction::where('user_id', auth()->id())
				->where('game_id', $request->game)
				->count();

			$statPredictionCount = (int)env('STAT_PREDICTION_COUNT');

			if ($predictionsCount >= $statPredictionCount) {
				return response()->json([
					'message' => "You can only make $statPredictionCount predictions per game"
				], 422);
			}

			$statPrediction = StatPrediction::create([
				'user_id' => auth()->id(),
				'game_id' => $request->game,
				'player_id' => $request->player,
				'type' => $request->type
			]);

			$statPrediction->load([
				'game',
				'player',
			]);

			return new StatPredictionResource($statPrediction);
		} catch (Exception) {
			return $this->errorResponse('Failed to create stat prediction', 500);
		}
	}

	public function import(ImportStatPredictionRequest $request): void {
		$bulk = collect($request->all())->map(function ($arr, $key) {
			return Arr::except($arr, ['game', 'player']);
		});

		StatPrediction::insert($bulk->toArray());
	}

	/**
	 * Display the specified resource.
	 */
	public function show(StatPrediction $statPrediction): StatPredictionResource {
		return new StatPredictionResource($statPrediction);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(StatPrediction $statPrediction) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateStatPredictionRequest $request, StatPrediction $statPrediction) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(StatPrediction $statPrediction) {
		//
	}
}
