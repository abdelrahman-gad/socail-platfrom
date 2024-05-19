<?php

namespace Tests\Feature\Api\Site;

use Tests\TestCase;
use App\Models\User;    
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class ProfileApiTest extends TestCase
{

    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();
        Artisan::call( 'db:seed', [ '--class' => 'PlainUserSeeder' ] );
    }

    public function test_user_can_show_profile()
    {
        $user = User::first();

        $response = $this->actingAs( $user, 'user-api' )->get( '/api/site/show-profile' );

        $response->assertStatus( 200 );
    }

    

}
