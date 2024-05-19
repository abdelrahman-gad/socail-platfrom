<?php

namespace Tests\Feature\Api\Site;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class AuthApiTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create();
        $user->is_active = 1;
        $user->save();

        $response = $this->postJson('/api/site/login', [
            'mobile' => $user->mobile,
            'password' => 'password',
        ]);
        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/site/register', [
            'name' => $this->faker->name,
            'mobile' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'username'=> $this->faker->userName,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200);
    }
  
}

  