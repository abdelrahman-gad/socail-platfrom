<?php

namespace Tests\Feature\Api\Site;

use Tests\TestCase;
use App\Models\User;    
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

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

    

}
