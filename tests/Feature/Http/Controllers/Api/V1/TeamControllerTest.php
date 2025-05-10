<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Models\Group;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TeamControllerTest extends TestCase
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

	public function test_index_returns_paginated_teams()
	{
		$group = Group::factory()->create();
		Team::factory()->count(10)->for($group)->create();

		$response = $this->getJson('/api/v1/teams?pageSize=5');

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
						// 'players', // Players are not loaded by default
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
			->assertJsonCount(5, 'data')
			->assertJsonPath('meta.per_page', 5);
	}

	public function test_index_returns_teams_with_players_if_requested()
	{
		$group = Group::factory()->create();
		$team = Team::factory()->for($group)->create();
		Player::factory()->count(3)->for($team)->create();

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
								'image',
								'isStar',
								'position',
								'goals',
								'assists',
								'isInjured',
							]
						]
					]
				]
			]);

		$this->assertNotEmpty($response->json('data.0.players'));
		$this->assertCount(3, $response->json('data.0.players'));
	}

	public function test_show_returns_a_single_team()
	{
		$group = Group::factory()->create();
		$team = Team::factory()->for($group)->create();

		$response = $this->getJson("/api/v1/teams/{$team->id}");

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
					// 'players' // Players are not loaded by default for the show method without a specific request parameter
				]
			])
			->assertJsonPath('data.id', $team->id)
			->assertJsonPath('data.name', $team->name)
			->assertJsonPath('data.group', $group->name);
	}

	public function test_show_returns_a_single_team_with_players_when_loaded()
	{
		$group = Group::factory()->create();
		$team = Team::factory()->for($group)->has(Player::factory()->count(2))->create();

		$response = $this->getJson("/api/v1/teams/{$team->id}?players=true");

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
					'players' => [
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
					]
				]
			])
			->assertJsonPath('data.id', $team->id)
			->assertJsonCount(2, 'data.players');
	}

	public function test_index_filters_teams_by_name_like_query()
	{
		$group = Group::factory()->create();
		Team::factory()->for($group)->create(['name' => 'Argentina National Team']);
		Team::factory()->for($group)->create(['name' => 'Brazil National Team']);
		Team::factory()->for($group)->create(['name' => 'German National Team']);

		$response = $this->getJson('/api/v1/teams?name[like]=national');

		$response->assertStatus(200)
			->assertJsonCount(3, 'data');
		$responseNames = collect($response->json('data'))->pluck('name');
		$this->assertTrue($responseNames->contains('Argentina National Team'));
		$this->assertTrue($responseNames->contains('Brazil National Team'));
		$this->assertTrue($responseNames->contains('German National Team'));


		$response = $this->getJson('/api/v1/teams?name[like]=argentina');
		$response->assertStatus(200)
			->assertJsonCount(1, 'data')
			->assertJsonPath('data.0.name', 'Argentina National Team');
	}

	public function test_index_respects_max_page_size_limit()
	{
		$group = Group::factory()->create();
		Team::factory()->count(60)->for($group)->create();

		$response = $this->getJson('/api/v1/teams?pageSize=100'); // Request more than max

		$response->assertStatus(200)
			->assertJsonCount(48, 'data') // Should be capped at 48
			->assertJsonPath('meta.per_page', 48);
	}

	public function test_show_returns_404_for_non_existent_team()
	{
		$response = $this->getJson('/api/v1/teams/99999'); // Non-existent ID
		$response->assertStatus(404);
	}
}
