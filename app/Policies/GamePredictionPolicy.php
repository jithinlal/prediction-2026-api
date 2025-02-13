<?php

namespace App\Policies;

use App\Models\GamePrediction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GamePredictionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GamePrediction $gamePrediction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GamePrediction $gamePrediction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GamePrediction $gamePrediction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GamePrediction $gamePrediction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GamePrediction $gamePrediction): bool
    {
        return false;
    }
}
