<?php

namespace Tests\Feature\Api\Site;

use App\Models\Post;
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

    public function test_user_can_list_posts()
    {
        $user = User::create([
            'name' => 'user',
            'email' => 'testuser@example.com',
            'username' => 'usertest',
            'password' => bcrypt('password'),
            'mobile'=> '+201022893369',
            'mobile_verified_at'=> now(),
            'email_verified_at' => now(),
            'is_active' => true
        ]);

        $response = $this->actingAs( $user, 'user-api' )->get( '/api/site/posts' );
        
        $response->assertStatus( 200 );
    }


    public function test_user_can_create_post()
    {
        $user = User::create([
            'name' => 'user',
            'email' => 'testuser@example.com',
            'username' => 'usertest',
            'password' => bcrypt('password'),
            'mobile'=> '+201022893369',
            'mobile_verified_at'=> now(),
            'email_verified_at' => now(),
            'is_active' => true
        ]);
   
        $response = $this->actingAs( $user, 'user-api' )->postJson('/api/site/posts', [
                    "title" => "testt",
                    "description" => "lorem ipsum",
        
        ]);

        $response->assertStatus(201);

    }

   

}
