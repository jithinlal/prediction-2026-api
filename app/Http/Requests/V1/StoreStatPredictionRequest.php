<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStatPredictionRequest extends FormRequest
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
						'player' => [
							'required',
							'exists:players,id',
							Rule::unique('stat_predictions', 'player_id')
								->where(function ($query) {
									return $query->where('game_id', $this->game)
										->where('type', $this->type)
										->where('user_id', $this->user()?->id);
								})
						],
						'type' => 'required|in:goal,yellow_card,red_card,clean_sheet',
        ];
    }

	public function messages(): array
	{
		return [
			'game.required' => 'A game must be selected.',
			'game.exists' => 'The selected game is invalid.',
			'player.required' => 'A player must be selected.',
			'player.exists' => 'The selected player is invalid.',
			'player.unique' => 'You have already made a prediction of this type for this player in the selected game.',
			'type.required' => 'A prediction type must be selected.',
			'type.in' => 'The prediction type must be either goal, yellow card, red card, or clean sheet.',
		];
	}

}
