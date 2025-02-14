<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStatRequest extends FormRequest
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
		$method = $this->method();

		if ($method === 'PUT') {
			return [
				'game' => ['required', 'exists:games,id'],
				'player' => ['required', 'exists:players,id'],
				'type' => ['required', Rule::in(['GOAL', 'ASSIST', 'YELLOW_CARD', 'RED_CARD', 'OWN_GOAL', 'CLEAN_SHEET'])],
			];
		} else {
			return [
				'game' => ['sometimes', 'required', 'exists:games,id'],
				'player' => ['sometimes', 'required', 'exists:players,id'],
				'type' => ['sometimes', 'required', Rule::in(['GOAL', 'ASSIST', 'YELLOW_CARD', 'RED_CARD', 'OWN_GOAL', 'CLEAN_SHEET'])],
			];
		}
	}

	protected function prepareForValidation(): void
	{
		$mergeItems = [];

		if ($this->game) {
			$mergeItems[] = ['game_id' => $this->game];
		}

		if ($this->player) {
			$mergeItems[] = ['player_id' => $this->player];
		}

		$this->merge($mergeItems);
	}
}
