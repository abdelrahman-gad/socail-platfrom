<?php

namespace Tests\Feature\Api\Dashboard;

use Tests\TestCase;
use App\Models\User;    
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostApiTest extends TestCase
{

    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();

    }

    public function test_admin_can_list_posts()
    {
        $user = User::create([
            'name' => 'user',
            'email' => 'testuser@example.com',
            'username' => 'usertest',
            'password' => bcrypt('password'),
            'mobile'=> '+201022893369',
            'mobile_verified_at'=> now(),
            'email_verified_at' => now(),
            'is_active' => true,
            'is_admin'
        ]);

        $response = $this->actingAs( $user, 'admin-api' )->get( '/api/site/posts' );
        
        $response->assertStatus( 200 );
    }


    public function test_admin_can_create_post()
    {
        $user = User::create([
            'name' => 'user',
            'email' => 'testuser@example.com',
            'username' => 'usertest',
            'password' => bcrypt('password'),
            'mobile'=> '+201022893369',
            'mobile_verified_at'=> now(),
            'email_verified_at' => now(),
            'is_active' => true,
            'is_admin' => true
        ]);
   
        $response = $this->actingAs( $user, 'admin-api' )->postJson('/api/site/posts', [
                    "title" => "testt",
                    "description" => "lorem ipsum",
        
        ]);

        $response->assertStatus(201);

    }

    

}
