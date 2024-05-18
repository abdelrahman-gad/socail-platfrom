<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Post\PostRequest;
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
        $direction = $request->direction ?? 'desc';

        $posts = $this->postRepository
                        ->with([
                            'author' => function($q){
                                $q->select('id','name');
                         }])
                         ->orderBy('created_at',$direction)
                         ->paginate( $perPage );

        return  PostResource::collection( $posts )->response();
    }

    public function show($id):JsonResponse{

        $post = $this->postRepository
                        ->with([
                            'author' => function($q){
                                $q->select('id','name');
                        }])
                        ->findOrFail( $id );


        return (new PostResource($post))->response();
    }

    public function store(PostRequest $request):JsonResponse{

        $request->merge([
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id,
        ]);
      
        $post = $this->postRepository->create($request->all());


        return (new PostResource($post))->response();
    }

}
