<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Traits\ReportTrait;

class DashboardController extends Controller
{
    use ReportTrait;

    public function activeUsers(){
        return User::count();
    }
    public function activePosts()
    {
        return Post::count();
    }

}
