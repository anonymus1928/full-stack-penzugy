<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class NewInvestmentTest extends TestCase
{
    public function testNewInvestmentWithNewShare() {
        Passport::actingAs(
            User::factory()->create()
        );
        $response = $this->json('POST', '/api/investments/new', ['symbol' => 'IBM', 'price' => 103.254, 'amount' => 5000, 'date' => now()]);

        $response
            ->assertStatus(201);
    }

    public function testNewInvestmentWithExistingShare() {
        Passport::actingAs(
            User::factory()->create()
        );
        $response = $this->json('POST', '/api/investments/new', ['symbol' => 'IBM', 'price' => 103.254, 'amount' => 5000, 'date' => now()]);

        $response
            ->assertStatus(201);
    }

    public function testNewInvestmentWithWrongSymbol() {
        Passport::actingAs(
            User::factory()->create()
        );
        $response = $this->json('POST', '/api/investments/new', ['symbol' => 'xyz', 'price' => 103.254, 'amount' => 5000, 'date' => now(), 'test' => true]);

        $response
            ->assertStatus(404)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testNewInvestmentWithoutSymbolGiven() {
        Passport::actingAs(
            User::factory()->create()
        );
        $response = $this->json('POST', '/api/investments/new', ['price' => 103.254, 'amount' => 5000, 'date' => now()]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testNewInvestmentWithoutPriceGiven() {
        Passport::actingAs(
            User::factory()->create()
        );
        $response = $this->json('POST', '/api/investments/new', ['symbol' => 'IBM', 'amount' => 5000, 'date' => now()]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testNewInvestmentWithoutAmountGiven() {
        Passport::actingAs(
            User::factory()->create()
        );
        $response = $this->json('POST', '/api/investments/new', ['symbol' => 'IBM', 'price' => 103.254, 'date' => now()]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testNewInvestmentWithoutDateGiven() {
        Passport::actingAs(
            User::factory()->create()
        );
        $response = $this->json('POST', '/api/investments/new', ['symbol' => 'IBM', 'price' => 103.254, 'amount' => 5000]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testNewInvestmentWithWrongPriceTypeGiven() {
        Passport::actingAs(
            User::factory()->create()
        );
        $response = $this->json('POST', '/api/investments/new', ['symbol' => 'IBM', 'price' => 'alma', 'amount' => 5000, 'date' => now()]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testNewInvestmentWithWrongAmountTypeGiven() {
        Passport::actingAs(
            User::factory()->create()
        );
        $response = $this->json('POST', '/api/investments/new', ['symbol' => 'IBM', 'price' => 103.254, 'amount' => 'alma', 'date' => now()]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testNewInvestmentWithWrongDateTypeGiven() {
        Passport::actingAs(
            User::factory()->create()
        );
        $response = $this->json('POST', '/api/investments/new', ['symbol' => 'IBM', 'price' => 103.254, 'amount' => 5000, 'date' => 123]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }
}
