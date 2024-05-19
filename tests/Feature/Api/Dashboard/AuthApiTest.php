<?php

namespace Tests\Feature\Api\Dashboard;

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
        $user->is_admin = 1;
        $user->save();

        $response = $this->postJson( '/api/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ] );

        $response->assertStatus( 200 );
    }

}

