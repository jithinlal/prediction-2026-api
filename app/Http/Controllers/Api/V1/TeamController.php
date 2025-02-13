<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\TeamFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\V1\TeamCollection;
use App\Http\Resources\V1\TeamResource;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request): TeamCollection
	{
		$filter = new TeamFilter();
		$query = Team::query();

		$queryItems = $filter->transform($request);

		$includePlayers = $request->query('includePlayers');

		if ($includePlayers) {
			$query = $query->with('players');
		}

		if (count($queryItems) === 0) {
			return new TeamCollection($query->paginate());
		}

		foreach ($queryItems as $item) {
			$query = match ($item[1]) {
				'LIKE' => $query->where($item[0], 'LIKE', $item[2]),
				'IN' => $query->whereIn($item[0], $item[2]),
				default => $query->where($item[0], $item[1], $item[2])
			};
		}

		return new TeamCollection($query->paginate()->appends($request->query()));
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
	public function store(StoreTeamRequest $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Team $team): TeamResource
	{
		return new TeamResource($team);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Team $team)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateTeamRequest $request, Team $team)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Team $team)
	{
		//
	}
}
