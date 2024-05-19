<?php

namespace Tests\Feature\Api\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;


class UserApiTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    function setUp(): void
    {
        parent::setUp();
    }

    function test_admin_can_list_users(){
        $admin = User::factory()->create();
        $admin->is_admin = 1;
        $admin->save();
        $response = $this->actingAs( $admin, 'admin-api' )->get('/api/admin/users');
        $response->assertStatus(200);
    }
  
}

  