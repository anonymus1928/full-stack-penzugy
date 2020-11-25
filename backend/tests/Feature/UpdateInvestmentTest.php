<?php

namespace Tests\Feature;

use App\Models\Investment;
use App\Models\Share;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UpdateInvestmentTest extends TestCase
{
    public function testUpdateInvestmentWithWrongPriceType() {
        User::factory()->make(['email' => 'patch@patch.hu'])->save();
        $user = User::where('email', '=', 'patch@patch.hu')->firstOrFail();

        Share::factory()->make(['symbol' => 'PATCH'])->save();
        $share = Share::where('symbol', '=', 'PATCH')->firstOrFail();

        Investment::factory()->make(['user_id' => $user->id, 'share_id' => $share->id])->save();
        $investment = $user->investments->first();

        Passport::actingAs(
            $user
        );
        $response = $this->json('PATCH', '/api/investments/' . $investment->id, ['price' => 'alma', 'amount' => 5000, 'date' => '2020-10-30']);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testUpdateInvestmentWithWrongAmountType() {
        $user = User::where('email', '=', 'patch@patch.hu')->firstOrFail();

        $investment = $user->investments->first();

        Passport::actingAs(
            $user
        );
        $response = $this->json('PATCH', '/api/investments/' . $investment->id, ['price' => 'alma', 'amount' => 'alma', 'date' => '2020-10-30']);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testUpdateInvestmentWithWrongDateType() {
        $user = User::where('email', '=', 'patch@patch.hu')->firstOrFail();

        $investment = $user->investments->first();

        Passport::actingAs(
            $user
        );
        $response = $this->json('PATCH', '/api/investments/' . $investment->id, ['price' => 2000.45, 'amount' => 6000, 'date' => 'alma']);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testUpdateInvestmentWithWrongId() {
        $user = User::where('email', '=', 'patch@patch.hu')->firstOrFail();

        $investment = $user->investments->first();

        Passport::actingAs(
            $user
        );
        $response = $this->json('PATCH', '/api/investments/400', ['price' => 2000.45, 'amount' => 6000, 'date' => '2020-10-26']);

        $response
            ->assertStatus(404)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testUpdateInvestmentSuccessfully() {
        $user = User::where('email', '=', 'patch@patch.hu')->firstOrFail();

        $investment = $user->investments->first();

        Passport::actingAs(
            $user
        );
        $response = $this->json('PATCH', '/api/investments/' . $investment->id, ['price' => 2000.45, 'amount' => 6000, 'date' => '2020-10-30']);

        $response
            ->assertStatus(200);
    }
}
