<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\GamePredictionFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGamePredictionRequest;
use App\Http\Requests\UpdateGamePredictionRequest;
use App\Http\Resources\v1\GamePredictionCollection;
use App\Http\Resources\v1\GamePredictionResource;
use App\Models\GamePrediction;
use Illuminate\Http\Request;

class GamePredictionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): GamePredictionCollection {
        $filter = new GamePredictionFilter();
				$query = GamePrediction::query();

				$query = $query->with('user');
				$query = $query->with('game');

				$queryItems = $filter->transform($request);

				if (count($queryItems) === 0) {
					return new GamePredictionCollection($query->paginate());
				}

				foreach ($queryItems as $item) {
					$query = match ($item[1]) {
						'LIKE' => $query->where($item[0], 'LIKE', $item[2]),
						'IN' => $query->whereIn($item[0], $item[2]),
						default => $query->where($item[0], $item[1], $item[2])
					};
				}

				return new GamePredictionCollection($query->paginate()->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGamePredictionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GamePrediction $gamePrediction): GamePredictionResource {
        return new GamePredictionResource($gamePrediction);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GamePrediction $gamePrediction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGamePredictionRequest $request, GamePrediction $gamePrediction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GamePrediction $gamePrediction)
    {
        //
    }
}
