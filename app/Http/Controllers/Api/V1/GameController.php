<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\GameFilter;
use App\Http\Controllers\ApiController;
use App\Http\Requests\V1\StoreGameRequest;
use App\Http\Requests\V1\UpdateGameRequest;
use App\Http\Resources\V1\GameCollection;
use App\Http\Resources\V1\GameResource;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends ApiController {
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request): GameCollection {
		$filter = new GameFilter();
		$query = Game::query();

		$query = $query->with('homeTeam');
		$query = $query->with('awayTeam');

		$queryItems = $filter->transform($request);

		if (count($queryItems) === 0) {
			return new GameCollection($query->paginate());
		}

		foreach ($queryItems as $item) {
			$query = match ($item[1]) {
				'LIKE' => $query->where($item[0], 'LIKE', $item[2]),
				'IN' => $query->whereIn($item[0], $item[2]),
				default => $query->where($item[0], $item[1], $item[2])
			};
		}

		return new GameCollection($query->paginate()->appends($request->query()));
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
	public function store(StoreGameRequest $request) {
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Game $game): GameResource {
		return new GameResource($game);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Game $game) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateGameRequest $request, Game $game) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Game $game) {
		//
	}
}
