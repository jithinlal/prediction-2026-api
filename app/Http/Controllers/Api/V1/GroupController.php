<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\V1\GroupCollection;
use App\Http\Resources\V1\GroupResource;
use App\Models\Group;

class GroupController extends ApiController {
	/**
	 * Display a listing of the resource.
	 */
	public function index(): GroupCollection {
		return new GroupCollection(Group::all());
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
	public function store(StoreGroupRequest $request) {
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Group $group): GroupResource {
		return new GroupResource($group);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Group $group) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateGroupRequest $request, Group $group) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Group $group) {
		//
	}
}
