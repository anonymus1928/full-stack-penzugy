<?php

namespace Tests\Feature;

use App\Models\Investment;
use App\Models\Share;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DeleteInvestmentTest extends TestCase
{
    public function testDeleteInvestmentWithWrongId() {
        User::factory()->make(['email' => 'delete@delete.hu'])->save();
        $user = User::where('email', '=', 'delete@delete.hu')->firstOrFail();

        Share::factory()->make(['symbol' => 'DELETE'])->save();
        $share = Share::where('symbol', '=', 'DELETE')->firstOrFail();

        Investment::factory()->make(['user_id' => $user->id, 'share_id' => $share->id])->save();
        Investment::factory()->make(['user_id' => $user->id, 'share_id' => $share->id])->save();
        Investment::factory()->make(['user_id' => $user->id, 'share_id' => $share->id])->save();

        Passport::actingAs(
            $user
        );
        $response = $this->json('DELETE', '/api/investments/100');

        $response
            ->assertStatus(404)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testDeleteInvestmentSuccessfully() {
        $user = User::where('email', '=', 'delete@delete.hu')->firstOrFail();

        $investment = $user->investments->first();

        Passport::actingAs(
            $user
        );
        $response = $this->json('DELETE', '/api/investments/' . $investment->id);

        $response
            ->assertStatus(200);
    }
}
