<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Repositories\Eloquents\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public PostRepository $postRepository;

    function  __construct( PostRepository $postRepository ) {
        $this->postRepository = $postRepository;
    }

    public function index( Request $request ):JsonResponse{

        $perPage = $request->perPage ?? 10;
        
        $user = Auth::user()->with(['type'])->first();
      
        $userType = $user->type;

        $user_type_id =  $userType->id;

        $posts = $this->postRepository->whereColumns(['is_active'=>true])
                        ->with([
                            'author' => function($q){
                                $q->select('id','name');
                         }])->paginate( $perPage );

        return  PostResource::collection( $posts )->response();
    }

    public function show($id):JsonResponse{

        $post = $this->postRepository->whereColumns(['is_active'=>true])
                ->with([
                    'author' => function($q){
                        $q->select('id','name');
                }])->findOrFail( $id );


        return (new PostResource($post))->response();
    }
    public function store(Request $request):JsonResponse{

        $post = $this->postRepository->create($request->all());

        return (new PostResource($post))->response();
    }

}
