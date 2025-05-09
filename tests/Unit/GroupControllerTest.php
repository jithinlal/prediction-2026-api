<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
	use RefreshDatabase;

	public function test_index_returns_group_collection()
	{
		$user = User::factory()->create();
		$this->actingAs($user, 'sanctum');

		Group::factory()->count(3)->create();

		$response = $this->getJson('/api/v1/groups');

		$response->assertStatus(200)
			->assertJsonStructure([
				'data' => [
					'*' => [
						'id',
						'name',
						'description',
						'createdAt',
						'updatedAt',
					]
				],
				'links' => [
					'first',
					'last',
					'prev',
					'next',
				],
				'meta' => [
					'current_page',
					'from',
					'last_page',
					'links' => [
						'*' => [
							'url',
							'label',
							'active',
						]
					],
					'path',
					'per_page',
					'to',
					'total',
				]
			]);
	}

	public function test_show_returns_single_group()
	{
		$user = User::factory()->create();
		$this->actingAs($user, 'sanctum');

		$group = Group::factory()->create();

		$response = $this->getJson('/api/v1/groups/' . $group->id);

		$response->assertStatus(200)
			->assertJsonStructure([
				'data' => [
					'id',
					'name',
					'description',
					'createdAt',
					'updatedAt',
				]
			])
			->assertJson([
				'data' => [
					'id' => $group->id,
				]
			]);
	}
}
