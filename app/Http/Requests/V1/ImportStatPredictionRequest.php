<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ImportStatPredictionRequest extends FormRequest
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
			'*.game' => 'required|exists:games,id',
			'*.player' => [
				'required',
				'exists:players,id',
				function ($attribute, $value, $fail) {
					$index = explode('.', $attribute)[0];
					$exists = DB::table('stat_predictions')
						->where('player_id', $value)
						->where('game_id', $this->input($index . '.game'))
						->where('type', $this->input($index . '.type'))
						->where('user_id', $this->user()?->id)
						->exists();

					if ($exists) {
						$fail('You have already made a prediction for this player in this game with the same type.');
					}
				}
			],
			'*.type' => 'required|in:goal,yellow_card,red_card,clean_sheet'
		];
	}

	protected function prepareForValidation():void
	{
		$data = [];

		foreach ($this->toArray() as $obj) {
			$obj['game_id'] = $obj['game'] ?? null;
			$obj['player_id'] = $obj['player'] ?? null;
			$obj['type'] = $obj['type'] ?? null;
			$obj['user_id'] = $this->user()?->id;
			$obj['created_at'] = now();
			$obj['updated_at'] = now();

			$data[] = $obj;
		}

		$this->merge($data);
	}

	public function messages(): array
	{
		return [
			'*.game_id.required' => 'The game ID field is required',
			'*.game_id.exists' => 'The selected game does not exist',
			'*.player_id.required' => 'The player ID field is required',
			'*.player_id.exists' => 'The selected player does not exist',
			'*.player_id.unique' => 'A prediction for this player already exists for this game and type',
			'*.type.required' => 'The type field is required',
			'*.type.in' => 'The type must be one of: goal, yellow card, red card, clean sheet'
		];
	}

}
