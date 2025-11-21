<?php

namespace App\Services;

use App\DTOs\CommentDTO;
use App\Events\CommentCreated;
use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Interfaces\CommentServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentService implements CommentServiceInterface
{
    protected $commentRepository;
    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }


    public function handleCreate(CommentDTO $commentDto): Comment
    {
        $commentDto->user_id = auth('api')->id();


        $comment = $this->commentRepository->create($commentDto);

        event(new CommentCreated($comment));

        return $comment;
    }

    public function handleUpdate(Comment $comment, CommentDTO $commentDto): Comment
    {
        return $this->commentRepository->update($comment, $commentDto);
    }

    public function handleDelete(Comment $comment)
    {
        $this->commentRepository->delete($comment);
    }

    public function getUserComments(int $userId): LengthAwarePaginator
    {
        return $this->commentRepository->getByUserId($userId);
    }
}
