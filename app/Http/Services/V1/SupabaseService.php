<?php

namespace App\Http\Services\V1;

use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class SupabaseService
{
	private string $url;
	private string $key;
	private string $bucket;

	private const SECONDS_IN_DAY = 86400;

	public function __construct()
	{
		$this->url = config('services.supabase.url');
		$this->key = config('services.supabase.key');
		$this->bucket = config('services.supabase.bucket');
	}

	/**
	 * @throws ConnectionException
	 * @throws Exception
	 */
	public function getSignedUrl($fileName): string
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . $this->key,
		])
			->post("$this->url/storage/v1/object/sign/$this->bucket/$fileName", [
				"expiresIn" => 999 * self::SECONDS_IN_DAY,
				// "transform" => [
				//   "height" => 100,
				//   "width" => 100,
				//   "resize" => "cover",
				//   "format" => "origin",
				//   "quality" => 100
				// ]
			]);


		if ($response->successful()) {
			return $this->url . "/storage/v1" . $response->json()['signedURL'];
		} else {
			throw new Exception('Failed to retrieve signed URL from Supabase: ' . $response->body());
		}
	}
}
