<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PlayerControllerTest extends TestCase
{
	use RefreshDatabase, WithFaker;

	protected function setUp(): void
	{
		parent::setUp();
		Sanctum::actingAs(
			User::factory()->create(),
			['*']
		);
	}

	public function test_index_returns_paginated_players()
	{
		$team = Team::factory()->create();
		Player::factory()->count(30)->for($team)->create();

		$response = $this->getJson('/api/v1/players?pageSize=20');

		$response->assertStatus(200)
			->assertJsonStructure([
				'data' => [
					'*' => [
						'id',
						'name',
						'image',
						'isStar',
						'position',
						'goals',
						'assists',
						'isInjured',
					]
				],
				'links' => ['first', 'last', 'prev', 'next'],
				'meta' => [
					'current_page',
					'from',
					'last_page',
					'path',
					'per_page',
					'to',
					'total'
				]
			])
			->assertJsonCount(20, 'data')
			->assertJsonPath('meta.per_page', 20);
	}

	public function test_index_returns_players_with_team_if_requested()
	{
		$team = Team::factory()->create();
		Player::factory()->count(5)->for($team)->create();

		$response = $this->getJson('/api/v1/players?team=true');

		$response->assertStatus(200)
			->assertJsonStructure([
				'data' => [
					'*' => [
						'id',
						'name',
						'team' => [
							'id',
							'name',
							'group',
							'continent',
							'image',
							'rank',
							'worldCups',
							'manager',
							'isEliminated',
						],
						'image',
						'isStar',
						'position',
						'goals',
						'assists',
						'isInjured',
					]
				]
			]);

		// Verify team is actually loaded
		$this->assertNotNull($response->json('data.0.team'));
		$this->assertEquals($team->id, $response->json('data.0.team.id'));
	}

	public function test_index_filters_star_players_only()
	{
		$team = Team::factory()->create();
		// Create some regular players
		Player::factory()->count(5)->for($team)->create(['is_star' => false]);
		// Create star players
		Player::factory()->count(3)->for($team)->create(['is_star' => true]);

		$response = $this->getJson('/api/v1/players?isStar=true');

		$response->assertStatus(200)
			->assertJsonCount(3, 'data');

		// Verify all returned players are stars
		foreach ($response->json('data') as $player) {
			$this->assertTrue($player['isStar']);
		}
	}

	public function test_index_filters_injured_players_only()
	{
		$team = Team::factory()->create();
		// Create some non-injured players
		Player::factory()->count(7)->for($team)->create(['is_injured' => false]);
		// Create injured players
		Player::factory()->count(4)->for($team)->create(['is_injured' => true]);

		$response = $this->getJson('/api/v1/players?isInjured=true');

		$response->assertStatus(200)
			->assertJsonCount(4, 'data');

		// Verify all returned players are injured
		foreach ($response->json('data') as $player) {
			$this->assertTrue($player['isInjured']);
		}
	}

	public function test_index_respects_max_page_size_limit()
	{
		$team = Team::factory()->create();
		Player::factory()->count(50)->for($team)->create();

		$response = $this->getJson('/api/v1/players?pageSize=100'); // Request more than max

		$response->assertStatus(200)
			->assertJsonCount(46, 'data') // Should be capped at 46
			->assertJsonPath('meta.per_page', 46);
	}

	public function test_show_returns_a_single_player()
	{
		$team = Team::factory()->create();
		$player = Player::factory()->for($team)->create();

		$response = $this->getJson("/api/v1/players/{$player->id}");

		$response->assertStatus(200)
			->assertJsonStructure([
				'data' => [
					'id',
					'name',
					'image',
					'isStar',
					'position',
					'goals',
					'assists',
					'isInjured',
				]
			])
			->assertJsonPath('data.id', $player->id)
			->assertJsonPath('data.name', $player->name);
	}

	public function test_show_returns_a_single_player_with_team_when_loaded()
	{
		$team = Team::factory()->create();
		$player = Player::factory()->for($team)->create();

		$response = $this->getJson("/api/v1/players/{$player->id}?team=true");

		$response->assertStatus(200)
			->assertJsonStructure([
				'data' => [
					'id',
					'name',
					'team' => [
						'id',
						'name',
						'group',
						'continent',
						'image',
						'rank',
						'worldCups',
						'manager',
						'isEliminated',
					],
					'image',
					'isStar',
					'position',
					'goals',
					'assists',
					'isInjured',
				]
			])
			->assertJsonPath('data.id', $player->id)
			->assertJsonPath('data.team.id', $team->id);
	}

	public function test_import_bulk_creates_players()
	{
		$team = Team::factory()->create();

		$playerData = [
			[
				'name' => 'Player 1',
				'team_id' => $team->id,
				'image' => 'http://example.com/image1.jpg',
				'is_star' => true,
				'position' => 'FWD',
				'goals' => 10,
				'assists' => 5,
				'is_injured' => false,
				'teamId' => $team->id, // This will be excluded in the controller
				'isStar' => true,      // This will be excluded in the controller
				'isInjured' => false,  // This will be excluded in the controller
			],
			[
				'name' => 'Player 2',
				'team_id' => $team->id,
				'image' => 'http://example.com/image2.jpg',
				'is_star' => false,
				'position' => 'MID',
				'goals' => 3,
				'assists' => 12,
				'is_injured' => true,
				'teamId' => $team->id,
				'isStar' => false,
				'isInjured' => true,
			]
		];

		$response = $this->postJson('/api/v1/players/import', $playerData);

		$response->assertStatus(200);

		// Check that players were created
		$this->assertDatabaseHas('players', [
			'name' => 'Player 1',
			'team_id' => $team->id,
			'is_star' => true,
			'position' => 'FWD',
			'goals' => 10,
			'assists' => 5,
			'is_injured' => false,
		]);

		$this->assertDatabaseHas('players', [
			'name' => 'Player 2',
			'team_id' => $team->id,
			'is_star' => false,
			'position' => 'MID',
			'goals' => 3,
			'assists' => 12,
			'is_injured' => true,
		]);
	}

	public function test_show_returns_404_for_non_existent_player()
	{
		$response = $this->getJson('/api/v1/players/99999'); // Non-existent ID

		$response->assertStatus(404);
	}
}
