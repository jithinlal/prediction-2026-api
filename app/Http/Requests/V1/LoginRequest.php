<?php

namespace App\Http\Requests\V1;

use App\Http\Requests\ApiRequest;

class LoginRequest extends ApiRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'email' => 'required|string|email',
			'password' => 'required|string',
		];
	}
}
