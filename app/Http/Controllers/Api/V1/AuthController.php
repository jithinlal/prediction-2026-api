<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Http\Services\V1\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController {
	public function __construct(private readonly AuthService $service) {
	}

	public function register(RegisterRequest $request): JsonResponse {
		$userData = $request->validated();

		try {
			$user = $this->service->doRegistration($userData);
		} catch (Exception $exception) {
			return $this->errorResponse(message: $exception->getMessage());
		}

		$tokens = $this->service->generateTokens($user);

		return $this->sendResponseWithTokens($tokens, [
			'user' => UserResource::make($user)
		]);
	}

	public function login(LoginRequest $request): JsonResponse {
		$credentials = $request->validated();

		if (!Auth::attempt($credentials)) {
			return response()->json([
				'message' => 'Invalid credentials'
			]);
		}

		$user = Auth::user();
		$tokens = $this->service->generateTokens($user);

		return $this->sendResponseWithTokens($tokens, [
			'user' => UserResource::make($user),
		]);
	}

	public function refresh(Request $request): JsonResponse {
		$user = Auth::user();
		$request->user()->tokens()->delete();
		$tokens = $this->service->generateTokens($user);

		return $this->sendResponseWithTokens($tokens);
	}

	public function logout(Request $request): JsonResponse {
		if (Auth::check()) {
			$request->user()->tokens()->delete();
		}
		$cookie = cookie()->forget('refreshToken');

		return $this
			->successResponse(message: 'Successfully logged out.')
			->withCookie($cookie);
	}

	private function sendResponseWithTokens(array $tokens, $body = []): JsonResponse {
		$rtExpireTime = config('sanctum.rt_expiration');
		$cookie = cookie('refreshToken', $tokens['refreshToken'], $rtExpireTime, secure: true);

		return $this->successResponse(array_merge($body, [
			'accessToken' => $tokens['accessToken']
		]))->withCookie($cookie);
	}
}
