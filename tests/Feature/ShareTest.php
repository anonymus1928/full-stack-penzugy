<?php

namespace Tests\Feature;

use App\Models\Share;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ShareTest extends TestCase
{
    public function testGetShareWithWrongSymbol() {
        Passport::actingAs(
            User::factory()->create()
        );
        $response = $this->json('GET', '/api/shares/ALMAFA');
        $response
            ->assertStatus(404);
    }

    public function testGetShareWithSymbol() {
        Passport::actingAs(
            User::factory()->create()
        );

        Share::factory()->create(['symbol' => 'SHARETEST'])->save();

        $response = $this->json('GET', '/api/shares/SHARETEST');
        $response
            ->assertStatus(200);
    }

    public function testCreateNewShare() {
        Passport::actingAs(
            User::factory()->create()
        );

        $response = $this->json('GET', '/api/shares/IBM');
        $response
            ->assertStatus(200);
    }

    public function testUpdateExistingShare() {
        Passport::actingAs(
            User::factory()->create()
        );

        $response = $this->json('PUT', '/api/shares/GOOG', ['test' => true]);
        $response
            ->assertStatus(200);
    }

    public function testCreateOrUpdateShareWithWrongSymbol() {
        Passport::actingAs(
            User::factory()->create()
        );

        $response = $this->json('PUT', '/api/shares/ASDF', ['test' => true]);
        $response
            ->assertStatus(404);
    }
}
