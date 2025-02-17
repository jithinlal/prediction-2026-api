<?php

namespace App\Http\Requests\V1;

use App\Http\Requests\ApiRequest;

class RegisterRequest extends ApiRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email',
			'password' => 'required|string',
		];
	}
}
