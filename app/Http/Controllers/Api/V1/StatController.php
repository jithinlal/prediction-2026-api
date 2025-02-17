<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\StatFilter;
use App\Http\Controllers\ApiController;
use App\Http\Requests\V1\StoreStatRequest;
use App\Http\Requests\V1\UpdateStatRequest;
use App\Http\Resources\V1\StatCollection;
use App\Http\Resources\V1\StatResource;
use App\Models\Stat;
use Illuminate\Http\Request;

class StatController extends ApiController {
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request): StatCollection {
		$filter = new StatFilter();
		$query = Stat::query();

		$query = $query->with('game');
		$query = $query->with('player');

		$queryItems = $filter->transform($request);

		if (count($queryItems) === 0) {
			return new StatCollection($query->paginate());
		}

		foreach ($queryItems as $item) {
			$query = match ($item[1]) {
				'LIKE' => $query->where($item[0], 'LIKE', $item[2]),
				'IN' => $query->whereIn($item[0], $item[2]),
				default => $query->where($item[0], $item[1], $item[2])
			};
		}

		return new StatCollection($query->paginate()->appends($request->query()));
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
	public function store(StoreStatRequest $request): StatResource {
		return new StatResource(Stat::create($request->all())->loadMissing('game', 'player'));
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Stat $stat): StatResource {
		return new StatResource($stat->loadMissing('game', 'player'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Stat $stat) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateStatRequest $request, Stat $stat): void {
		$stat->update($request->all());
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Stat $stat) {
		//
	}
}
