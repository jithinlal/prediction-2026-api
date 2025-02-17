<?php

namespace App\Http\Services\V1;

use App\Enums\TokenAbility;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthService
{
	public function generateTokens($user): array
	{
		$atExpireTime = now()->addMinutes(config('sanctum.expiration'));
		$rtExpireTime = now()->addMinutes(config('sanctum.rt_expiration'));

		$accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API], $atExpireTime);
		$refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN], $rtExpireTime);

		return [
			'accessToken' => $accessToken->plainTextToken,
			'refreshToken' => $refreshToken->plainTextToken,
		];
	}

	/**
	 * @throws Exception
	 */
	public function doRegistration($userData): User
	{
		$userCount = User::where('email', $userData['email'])->count();
		if ($userCount > 0) {
			throw new Exception('The email is already taken.');
		}

		return User::create([
			'name' => $userData['name'],
			'email' => $userData['email'],
			'password' => Hash::make($userData['password']),
			'role' => 'USER',
		]);
	}
}
