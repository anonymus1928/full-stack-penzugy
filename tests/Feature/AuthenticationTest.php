<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class AuthenticationTest extends TestCase
{
    public function testRegisterUserWithoutNameGiven() {
        $response = $this->json('POST', '/api/register', ['email' => 'q@q.hu', 'password' => 'p']);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testRegisterUserWithoutEmailGiven() {
        $response = $this->json('POST', '/api/register', ['name' => 'Teszt Felhasználó', 'password' => 'p']);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testRegisterUserWithoutPasswordGiven() {
        $response = $this->json('POST', '/api/register', ['name' => 'Teszt Felhasználó', 'email' => 'q.hu']);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testRegisterUserWithWrongEmail() {
        $response = $this->json('POST', '/api/register', ['name' => 'Teszt Felhasználó', 'email' => 'q.hu', 'password' => 'p']);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testRegisterUserWithValidDatas() {
        $response = $this->json('POST', '/api/register', ['name' => 'Teszt Felhasználó', 'email' => 'q@q.hu', 'password' => 'p']);

        $response
            ->assertStatus(201)
            ->assertJson([
                'status' => 'OK',
            ]);
    }

    public function testGetInfoWithoutAuthentication() {
        $response = $this->get('/api/info');

        $response
            ->assertStatus(401)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testGetInfoWithAuthentication() {
        Passport::actingAs(
            User::factory()->create()
        );

        $response = $this->get('/api/info');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'OK',
            ]);
    }
}
