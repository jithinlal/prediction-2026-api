<?php

namespace App\Http\Requests\V1;

use App\Models\GamePrediction;
use Illuminate\Foundation\Http\FormRequest;

class StoreGamePredictionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
					'game' => 'required|exists:games,id',
					'homeGoals' => 'required|integer|min:0',
					'awayGoals' => 'required|integer|min:0',
					'homePenaltyGoals' => 'nullable|integer|min:0',
					'awayPenaltyGoals' => 'nullable|integer|min:0',
        ];
    }

		protected function prepareForValidation(): void
		{
			$this->merge([
				'game_id' => $this->game ?? null,
				'home_goals' => $this->homeGoals ?? null,
				'away_goals' => $this->awayGoals ?? null,
				'user_id' => $this->user()?->id,
				'home_penalty_goals' => $this->homePenaltyGoals ?? null,
				'away_penalty_goals' => $this->awayPenaltyGoals ?? null,
			]);
		}
}
