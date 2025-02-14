<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStatRequest extends FormRequest
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
			'game' => ['required', 'exists:games,id'],
			'player' => ['required', 'exists:players,id'],
			'type' => ['required', Rule::in(['GOAL', 'ASSIST', 'YELLOW_CARD', 'RED_CARD', 'OWN_GOAL', 'CLEAN_SHEET'])],
		];
	}

	protected function prepareForValidation(): void
	{
		$this->merge([
			'game_id' => $this->game,
			'player_id' => $this->player,
		]);
	}
}
