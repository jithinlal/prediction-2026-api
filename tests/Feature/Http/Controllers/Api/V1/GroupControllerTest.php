<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();
		Sanctum::actingAs(
			User::factory()->create(),
			['*']
		);
	}

	public function test_index_returns_all_groups(): void
	{
		Group::factory()->count(3)->create();

		$response = $this->getJson('/api/v1/groups');

		$response->assertStatus(200)
			->assertJsonCount(3, 'data')
			->assertJsonStructure([
				'data' => [
					'*' => [
						'id',
						'name',
					]
				]
			]);
	}

	public function test_show_returns_a_specific_group(): void
	{
		$group = Group::factory()->create();

		$response = $this->getJson('/api/v1/groups/' . $group->id);

		$response->assertStatus(200)
			->assertJson([
				'data' => [
					'id' => $group->id,
					'name' => $group->name,
				]
			]);
	}
}
