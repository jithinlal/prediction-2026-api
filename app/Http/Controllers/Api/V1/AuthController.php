<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\RefreshToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller {
	/**
	 * The cookie names used for tokens
	 */
	const ACCESS_TOKEN_COOKIE = 'access_token';
	const REFRESH_TOKEN_COOKIE = 'refresh_token';

	/**
	 * Token expiration times in minutes
	 */
	const ACCESS_TOKEN_EXPIRATION = 60 * 24; // 24 hours
	const REFRESH_TOKEN_EXPIRATION = 60 * 24 * 30; // 30 days

	public function register(Request $request) {
		$request->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'unique:users'],
			'password' => ['required', 'string'],
		]);

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'role' => 'USER',
		]);

		return $this->createTokensAndRespond($user, 'User registered successfully');
	}

	public function login(Request $request) {
		$request->validate([
			'email' => ['required', 'email'],
			'password' => ['required']
		]);

		$user = User::where('email', $request->email)->first();

		if (!$user || !Hash::check($request->password, $user->password)) {
			return response()->json([
				'message' => 'Invalid credentials'
			], 401);
		}

		$user->refreshTokens()->delete();

		return $this->createTokensAndRespond($user, 'Logged in successfully');
	}

	public function refresh(Request $request) {
		try {
			$refreshToken = $request->cookie(self::REFRESH_TOKEN_COOKIE);

			if (!$refreshToken) {
				return response()->json([
					'message' => 'Invalid refresh token',
				], 401);
			}

			$refreshTokenModel = RefreshToken::where('token', $refreshToken)
				->where('expires_at', '>', now())
				->first();

			if (!$refreshTokenModel) {
				return response()->json([
					'message' => 'Invalid or expired refresh token',
				], 401);
			}

			$user = $refreshTokenModel->user;

			$user->tokens()->delete();
			$refreshTokenModel->delete();

			return $this->createTokensAndRespond($user, 'Token refreshed successfully');
		} catch (\Exception $e) {
			return response()->json([
				'message' => 'Something went wrong',
				'error' => $e->getMessage(),
			], 500);
		}
	}

	public function logout(Request $request) {
		try {
			$request->user()->tokens()->delete();

			$refreshToken = $request->cookie(self::REFRESH_TOKEN_COOKIE);
			if ($refreshToken) {
				RefreshToken::where('token', $refreshToken)->delete();
			}

			$response = response()->json([
				'message' => 'Logged out successfully'
			]);

			return $this->clearTokenCookies($response);
		} catch (\Exception $e) {
			return response()->json([
				'message' => 'Something went wrong',
				'error' => $e->getMessage(),
			], 500);
		}
	}

	private function createTokensAndRespond(User $user, string $message) {
		$accessToken = $user->createToken('auth_token', [$user->role])->plainTextToken;
		$refreshToken = Str::random(64);

		$user->refreshTokens()->create([
			'token' => $refreshToken,
			'expires_at' => now()->addMinutes(self::REFRESH_TOKEN_EXPIRATION),
		]);

		$response = response()->json([
			'message' => $message,
			'user' => $user,
		]);

		return $this->setTokenCookies($response, $accessToken, $refreshToken);
	}

	private function setTokenCookies($response, $accessToken, $refreshToken) {
		$secure = !app()->environment('local');

		return $response->cookie(
			self::ACCESS_TOKEN_COOKIE,
			$accessToken,
			self::ACCESS_TOKEN_EXPIRATION,
			'/',
			null,
			$secure,
			true,
			false,
			'Lax'
		)->cookie(
			self::REFRESH_TOKEN_COOKIE,
			$refreshToken,
			self::REFRESH_TOKEN_EXPIRATION,
			'/',
			null,
			$secure,
			true,
			false,
			'Lax'
		);
	}

	private function clearTokenCookies($response) {
		return $response
			->cookie(
				self::ACCESS_TOKEN_COOKIE,
				null,
				-1,
				"/",
				null,
				!app()->environment('local'),
				true,
				false,
				'Strict'
			)->cookie(
				self::REFRESH_TOKEN_COOKIE,
				null,
				-1,
				'/',
				null,
				!app()->environment('local'),
				true,
				false,
				'Strict'
			);
	}
}
