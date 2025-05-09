<?php

namespace Tests\Unit;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerControllerTest extends TestCase
{
	use RefreshDatabase;

	protected User $user;

	protected function setUp(): void
	{
		parent::setUp();
		$this->user = User::factory()->create();
		$this->actingAs($this->user, 'sanctum');
	}

	public function test_index_returns_player_collection()
	{
		Player::factory()->count(5)->create();

		$response = $this->getJson('/api/v1/players');

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
						'isInjured'
						// 'team' is not included by default
					]
				],
				'links', // Simplified for brevity, can expand like in TeamControllerTest
				'meta',
			]);
	}

	public function test_index_returns_player_collection_with_team()
	{
		Player::factory()->count(3)->create();

		$response = $this->getJson('/api/v1/players?team=true');

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
						]
					]
				]
			]);
	}

	public function test_index_filters_by_is_star()
	{
		Player::factory()->create(['is_star' => true]);
		Player::factory()->create(['is_star' => false]);

		$response = $this->getJson('/api/v1/players?isStar=true');

		$response->assertStatus(200);
		foreach ($response->json('data') as $player) {
			$this->assertTrue($player['isStar']);
		}
		$this->assertCount(1, $response->json('data'));
	}

	public function test_index_filters_by_is_injured()
	{
		Player::factory()->create(['is_injured' => true]);
		Player::factory()->create(['is_injured' => false]);

		$response = $this->getJson('/api/v1/players?isInjured=true');

		$response->assertStatus(200);
		foreach ($response->json('data') as $player) {
			$this->assertTrue($player['isInjured']);
		}
		$this->assertCount(1, $response->json('data'));
	}

	public function test_show_returns_single_player()
	{
		$player = Player::factory()->create();
		// Eager load team to ensure it's available for the resource if show method loads it
		$player->load('team');

		$response = $this->getJson('/api/v1/players/' . $player->id);

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
					// Note: PlayerResource only includes 'team' if it's loaded.
					// The controller's show method might not load it by default.
					// If it should, the controller needs: $player->load('team');
				]
			])
			->assertJson([
				'data' => [
					'id' => $player->id,
					'name' => $player->name,
				]
			]);
		// If team is expected in show, add this check after ensuring controller loads it:
		// if ($player->relationLoaded('team')) {
		//     $response->assertJsonPath('data.team.id', $player->team->id);
		// }
	}

	public function test_import_players()
	{
		$team = Team::factory()->create();
		$playersData = [
			[
				'name' => 'Player One',
				'team_id' => $team->id,
				'image' => 'http://example.com/player1.jpg',
				'is_star' => true,
				'position' => 'FWD',
				'goals' => 10,
				'assists' => 5,
				'is_injured' => false,
				// 'teamId' is in the request but removed by controller before insert
				'teamId' => $team->id,
			],
			[
				'name' => 'Player Two',
				'team_id' => $team->id,
				'image' => 'http://example.com/player2.jpg',
				'is_star' => false,
				'position' => 'MID',
				'goals' => 2,
				'assists' => 8,
				'is_injured' => true,
				'teamId' => $team->id,
			],
		];

		$response = $this->postJson('/api/v1/players/import', $playersData);

		// The controller method has a void return type, which typically results in a 204 No Content or 200 OK.
		// Let's assume 200 OK for now as per common practice if no explicit status is set for void returns.
		$response->assertStatus(200); // Or 204 if that's the actual behavior.

		// Assert players were created in the database
		$this->assertDatabaseHas('players', ['name' => 'Player One', 'team_id' => $team->id]);
		$this->assertDatabaseHas('players', ['name' => 'Player Two', 'team_id' => $team->id]);
	}
}
