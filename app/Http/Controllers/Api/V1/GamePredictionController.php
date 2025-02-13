<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGamePredictionRequest;
use App\Http\Requests\UpdateGamePredictionRequest;
use App\Models\GamePrediction;

class GamePredictionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(GamePrediction $gamePrediction)
    {
        //
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
