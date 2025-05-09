<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamControllerTest extends TestCase
{
	use RefreshDatabase;

	public function test_index_returns_team_collection()
	{
		$user = User::factory()->create();
		$this->actingAs($user, 'sanctum');

		// Ensure groups are created for the teams
		Team::factory()->count(3)->create();

		$response = $this->getJson('/api/v1/teams');

		$response->assertStatus(200)
			->assertJsonStructure([
				'data' => [
					'*' => [
						'id',
						'name',
						'group', // Changed from individual group fields
						'continent',
						'image',
						'rank',
						'worldCups', // Changed from world_cups
						'manager',   // Changed from manager_name
						'isEliminated', // Changed from is_eliminated
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

	public function test_index_returns_team_collection_with_players()
	{
		$user = User::factory()->create();
		$this->actingAs($user, 'sanctum');

		$team = Team::factory()->create(); // Group is created by factory
		Player::factory()->count(2)->create(['team_id' => $team->id]);

		$response = $this->getJson('/api/v1/teams?players=true');

		$response->assertStatus(200)
			->assertJsonStructure([
				'data' => [
					'*' => [
						'id',
						'name',
						'group',
						'continent',
						'image',
						'rank',
						'worldCups',
						'manager',
						'isEliminated',
						'players' => [
							'*' => [
								'id',
								'name',
								// Add other PlayerResource fields here if needed
							]
						]
					]
				],
			]);
	}

	public function test_show_returns_single_team()
	{
		$user = User::factory()->create();
		$this->actingAs($user, 'sanctum');

		$team = Team::factory()->create(); // Group is created by factory

		$response = $this->getJson('/api/v1/teams/' . $team->id);

		$response->assertStatus(200)
			->assertJsonStructure([
				'data' => [
					'id',
					'name',
					'group',
					'continent',
					'image',
					'rank',
					'worldCups',
					'manager',
					'isEliminated',
				]
			])
			->assertJson([
				'data' => [
					'id' => $team->id,
					// We can also assert other specific values if needed, e.g., name
					'name' => $team->name,
					'group' => $team->group->name, // Asserting the group name
				]
			]);
	}

	public function test_store_creates_new_team_placeholder()
	{
		$user = User::factory()->create();
		$this->actingAs($user, 'sanctum');

		// Need a group for the team
		$group = Group::factory()->create();

		$teamData = [
			'name' => 'Test Team FC Unique',
			'group_id' => $group->id, // Pass group_id
			'continent' => 'Antarctica',
			'image' => 'http://example.com/logo.png',
			'rank' => 10,
			'world_cups' => 1,
			'manager_name' => 'Test Manager',
			'is_eliminated' => false,
		];

		$response = $this->postJson('/api/v1/teams', $teamData);

		$response->assertStatus(201);
	}
}
