<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Post\PostRequest;
use App\Models\User;
use App\Models\Post;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\PostRepository;

class DashboardController extends Controller
 {
    protected UserRepository $userRepository;
    protected PostRepository $postRepository;

    function __construct(
        UserRepository $userRepository,
        PostRepository $postRepository

    )
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;

    }

    public function activeUsers() {
     return $this->userRepository->count('id');  
    }

    public function activePosts()
    {
        return $this->postRepository->count('id');
    }

}
