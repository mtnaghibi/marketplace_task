<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_will_register_a_user()
    {
        $response = $this->post('api/v1/auth/register', [
            'name' => 'test',
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $response->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expires_in'
            ],
            'meta' => [
                'code'
            ]
        ]);
    }

    /** @test */
    public function it_will_log_a_user_in()
    {
        $user = factory(User::class)->create([
            'password'=> bcrypt('123456')
        ]);
        $response = $this->post('api/v1/auth/login', [
            'email' => $user->email,
            'password' => '123456'
        ]);

        $response->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expires_in'
            ],
            'meta' => [
                'code'
            ]
        ]);
    }
}
