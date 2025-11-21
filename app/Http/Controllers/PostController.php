<?php

namespace App\Http\Controllers;

use App\DTOs\FilterDTO;
use App\DTOs\PostDTO;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PostController extends BaseController
{
    use AuthorizesRequests;

    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->middleware('auth:api')->except(['index', 'show', 'getUserPosts']);

        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = FilterDTO::from($request);

        $posts = $this->postService->handleAll($filters);

        return PostResource::collection($posts);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $postDTO = PostDTO::from($request->validated());

        $post = $this->postService->handleCreate($postDTO);

        return response()->json([
            'message' => 'Post created successfully',
            'post' => new PostResource($post)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->postService->handleById($id);

        return new PostResource($post);
    }


    public function update(UpdatePostRequest $request, Post $post)
    {

        $this->authorize('update', [Post::class, $post]);

        $postDTO = PostDTO::from($request->validated());

        $updatedPost = $this->postService->handleUpdate($post, $postDTO);

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => new PostResource($updatedPost)
        ]);
    }


    public function destroy(Post $post)
    {
        $this->authorize('delete', [Post::class, $post]);

        $this->postService->handleDelete($post);

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
