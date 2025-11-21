<?php

namespace App\Repositories;

use App\DTOs\CommentDTO;
use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentRepository implements CommentRepositoryInterface
{

    public function create(CommentDTO $commentDTO): Comment
    {
        return Comment::create($commentDTO->toArray());
    }

    public function update(Comment $comment, CommentDTO $data): Comment
    {
        $comment->update(['content' => $data->content]);

        return $comment;
    }

    public function delete(Comment $comment): void
    {

        $comment->delete();
    }

    public function getByUserId(int $userId): LengthAwarePaginator
    {
        return Comment::with('user')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(100);
    }

}

