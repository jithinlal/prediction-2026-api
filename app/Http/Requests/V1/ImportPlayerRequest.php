<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImportPlayerRequest extends FormRequest
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
					'*.name' => ['required'],
					'*teamId' => ['required', 'exists:teams,id'],
					'*.image' => ['required'],
					'*.position' => ['required', Rule::in(['GK', 'DEF', 'MID', 'FWD'])],
					'*.goals' => ['numeric'],
					'*.assists' => ['numeric'],
					'*.isStar' => ['boolean'],
					'*.isInjured' => ['boolean'],
        ];
    }

	protected function prepareForValidation(): void
	{
		$data = [];

		foreach ($this->toArray() as $obj) {
			$obj['name'] = $obj['name'] ?? null;
			$obj['team_id'] = $obj['teamId'] ?? null;
			$obj['image'] = $obj['image'] ?? null;
			$obj['position'] = $obj['position'] ?? null;
			$obj['goals'] = $obj['goals'] ?? 0;
			$obj['assists'] = $obj['assists'] ?? 0;
			$obj['isStar'] = $obj['isStar'] ?? false;
			$obj['isInjured'] = $obj['isInjured'] ?? false;

			$data[]	= $obj;
		}

		$this->merge($data);
	}
}
