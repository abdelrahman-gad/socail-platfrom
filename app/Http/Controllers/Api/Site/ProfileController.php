<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

use App\Repositories\Eloquents\UserRepository;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public UserRepository $userRepository;

    function  __construct( UserRepository $userRepository ) {
        $this->userRepository = $userRepository;
    }

    public function show():JsonResponse{

        $user = auth()->user();

        return (new UserResource($user))->response();
    }

}
