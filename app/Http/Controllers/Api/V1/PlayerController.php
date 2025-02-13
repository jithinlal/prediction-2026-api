<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Http\Resources\V1\PlayerCollection;
use App\Http\Resources\V1\PlayerResource;
use App\Models\Player;
use App\Filters\V1\PlayerFilter;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request): PlayerCollection
	{
		$filter = new PlayerFilter();
		$query = Player::query();

		$queryItems = $filter->transform($request);

		$isStar = $request->query('isStar');
		$isInjured = $request->query('isInjured');

		if ($isStar) {
			$query = $query->where('is_star', '=', true);
		}

		if ($isInjured) {
			$query = $query->where('is_injured', '=', true);
		}

		if (count($queryItems) === 0) {
			return new PlayerCollection($query->paginate());
		}

		foreach ($queryItems as $item) {
			$query = match ($item[1]) {
				'LIKE' => $query->where($item[0], 'LIKE', $item[2]),
				'IN' => $query->whereIn($item[0], $item[2]),
				default => $query->where($item[0], $item[1], $item[2])
			};
		}

		return new PlayerCollection($query->paginate()->appends($request->query()));
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
	public function store(StorePlayerRequest $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Player $player): PlayerResource
	{
		return new PlayerResource($player);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Player $player)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdatePlayerRequest $request, Player $player)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Player $player)
	{
		//
	}
}
