<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;

class DashboardController extends Controller
{

    public function activeUsers(){
        return User::count();
    }
    public function activePosts()
    {
        return Post::count();
    }

}
