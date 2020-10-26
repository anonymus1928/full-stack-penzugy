<?php

namespace Tests\Feature;

use App\Models\Investment;
use App\Models\Share;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

class InvestmentTest extends TestCase
{
    public function testGetInvestments() {
        User::factory()->make(['email' => 'test@test.hu'])->save();

        $user = User::where('email', '=', 'test@test.hu')->firstOrFail();

        Share::factory()->make(['symbol' => 'QWE'])->save();

        $share = Share::where('symbol', '=', 'QWE')->firstOrFail();

        Investment::factory()->make(['share_id' => $share->id, 'user_id' => $user->id])->save();
        Investment::factory()->make(['share_id' => $share->id, 'user_id' => $user->id])->save();
        Investment::factory()->make(['share_id' => $share->id, 'user_id' => $user->id])->save();
        Investment::factory()->make(['share_id' => $share->id, 'user_id' => $user->id])->save();
        Investment::factory()->make(['share_id' => $share->id, 'user_id' => $user->id])->save();

        Passport::actingAs(
            User::where('email', '=', 'test@test.hu')->firstOrFail()
        );
        $response = $this->json('GET', '/api/investments');

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'investments');
    }

    public function testGetInvestmentWithId() {
        User::factory()->make(['email' => 'testid@testid.hu'])->save();

        $user = User::where('email', '=', 'testid@testid.hu')->firstOrFail();

        $investment = Investment::factory()->make(['user_id' => $user->id]);

        Passport::actingAs(
            User::where('email', '=', 'testid@testid.hu')->firstOrFail()
        );
        $response = $this->json('GET', '/api/investments/' . $investment->id);

        $response
            ->assertStatus(200);
    }

    public function testGetInvestmentWithWrongId() {
        User::factory()->make(['email' => 'testid2@testid2.hu'])->save();

        Passport::actingAs(
            User::where('email', '=', 'testid2@testid2.hu')->firstOrFail()
        );
        $response = $this->json('GET', '/api/investments/1');

        $response
            ->assertStatus(404)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testGetInvestmentsWithSymbol() {
        User::factory()->make(['email' => 'testsymbol@testsymbol.hu'])->save();

        Share::factory()->make(['symbol' => 'ASD'])->save();

        Passport::actingAs(
            User::where('email', '=', 'testsymbol@testsymbol.hu')->firstOrFail()
        );

        $user = User::where('email', '=', 'testsymbol@testsymbol.hu')->firstOrFail();

        $share = Share::where('symbol', '=', 'ASD')->firstOrFail();

        Investment::factory()->make(['user_id' => $user->id, 'share_id' => $share->id])->save();
        Investment::factory()->make(['user_id' => $user->id, 'share_id' => $share->id])->save();
        Investment::factory()->make(['user_id' => $user->id, 'share_id' => $share->id])->save();

        $response = $this->json('GET', '/api/investments/ASD');

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'investments');
    }

    public function testGetInvestmentsWithWrongSymbol() {
        User::factory()->make(['email' => 'testsymbol2@testsymbol2.hu'])->save();

        Passport::actingAs(
            User::where('email', '=', 'testsymbol2@testsymbol2.hu')->firstOrFail()
        );
        $response = $this->json('GET', '/api/investments/xyz');

        $response
            ->assertStatus(404)
            ->assertJson([
                'status' => 'error',
            ]);
    }
}
