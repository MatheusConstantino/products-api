<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function createAuthenticatedUser()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $token = auth()->login($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function testGetAllUsers()
    {
        $authenticatedUser = $this->createAuthenticatedUser();
        $response = $this->get('/api/users', [
            'Authorization' => 'Bearer ' . $authenticatedUser['token'],
        ]);
    
        $response->assertStatus(200);
    }

    public function testCreateUser()
    {
        $authenticatedUser = $this->createAuthenticatedUser();

        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ];

        $response = $this->post('/api/users', $userData, [
            'Authorization' => 'Bearer ' . $authenticatedUser['token'],
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);
    }

    public function testShowUser()
    {
        $authenticatedUser = $this->createAuthenticatedUser();
        $user = User::factory()->create();

        $response = $this->get('/api/users/' . $user->id, [
            'Authorization' => 'Bearer ' . $authenticatedUser['token'],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testUpdateUser()
    {
        $authenticatedUser = $this->createAuthenticatedUser();
        $user = User::factory()->create();
    
        $userData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];
    
        $response = $this->put('/api/users/' . $user->id, $userData, [
            'Authorization' => 'Bearer ' . $authenticatedUser['token'],
        ]);
    
        $response->assertStatus(201);
        $response->assertJson([
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);
    }

    public function testDeleteUser()
    {
        $authenticatedUser = $this->createAuthenticatedUser();
        $user = User::factory()->create();

        $response = $this->delete('/api/users/' . $user->id, [], [
            'Authorization' => 'Bearer ' . $authenticatedUser['token'],
        ]);

        $response->assertStatus(204);
    }
}
