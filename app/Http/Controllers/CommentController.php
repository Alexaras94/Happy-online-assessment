<?php

namespace App\Http\Controllers;

use App\DTOs\CommentDTO;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Services\Interfaces\CommentServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class CommentController extends BaseController
{
    use AuthorizesRequests;

    protected $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->middleware('auth:api')->only(['store','update','destroy']);

        $this->commentService = $commentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function update(UpdateCommentRequest $request, Comment $comment )
    {
        $this->authorize('update', [Comment::class, $comment]);

        $commentDto= new CommentDTO(
            content: $request->validated()['content'],
            post_id: $comment->post_id,
            user_id: $comment->user_id
        );

        $updatedComment = $this->commentService->handleupdate($comment, $commentDto);

        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => new CommentResource($updatedComment)
        ]);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $commentDto=CommentDTO::from($request->validated());

        $comment=$this->commentService->handleCreate($commentDto);

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => new CommentResource($comment)
        ], 201);
    }


    public function getUserComments(int $userId)
    {

        $comments = $this->commentService->getUserComments($userId);


        return CommentResource::collection($comments);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', [Comment::class, $comment]);

        $this->commentService->handleDelete($comment);

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
