<?php

namespace App\Http\Requests\V1;

use App\Models\StatPrediction;
use Illuminate\Foundation\Http\FormRequest;

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
			'*.game' => [
				'required',
				'exists:games,id',
				function ($attribute, $value, $fail) {
					$firstGameId = $this->input('0.game');
					if ($value !== $firstGameId) {
						$fail('All predictions must be for the same game.');
					}
				}
			],
			'*.player' => 'required|exists:players,id',
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
			'*.type.required' => 'The type field is required',
			'*.type.in' => 'The type must be one of: goal, yellow card, red card, clean sheet'
		];
	}

}
