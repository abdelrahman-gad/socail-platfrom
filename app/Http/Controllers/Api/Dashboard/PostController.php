<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Post\PostRequest;
use App\Http\Resources\PostListResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Eloquents\PostRepository;

class PostController extends Controller
{
    protected PostRepository $postRepository;

    function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = $this->postRepository->whereColumns([
            'title' => $search,
            'content' => $search,
        ])
        ->with(['author'])
        ->sortBy($sortField, $sortDirection)
        ->paginate($perPage);

        return PostListResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $post = $this->postRepository->create($data);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post = $this->postRepository->find($post->id);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post      $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
       
        $this->postRepository->update($post->id, $data);

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->postRepository->delete($post->id);

        return response()->noContent();
    }

  

 

}
