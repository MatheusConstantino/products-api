<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * Test login route.
     *
     * @return void
     */
    public function testLogin()
    {
        $password = $this->faker->password;
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => $password,
        ];

        $response = $this->postJson('/api/login', $credentials);
        $response->assertStatus(200);
        $this->assertArrayHasKey('token', $response->json());
    }
}
