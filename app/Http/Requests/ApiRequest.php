<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
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
			//
		];
	}

	public function failedValidation(Validator $validator): void
	{
		$VALID_FAIL_STATUS_CODE = 422;

		throw new HttpResponseException(response()->json([
			'status' => false,
			'message' => 'Validation errors',
			'errors' => $validator->errors()
		])->setStatusCode($VALID_FAIL_STATUS_CODE));
	}
}
