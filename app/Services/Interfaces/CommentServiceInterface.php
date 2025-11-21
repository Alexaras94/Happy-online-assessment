<?php

namespace App\Services\Interfaces;

use App\DTOs\CommentDTO;
use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;

interface CommentServiceInterface
{

    public function handleCreate (CommentDTO $CommentDto): Comment;
    public function getUserComments(int $userId): LengthAwarePaginator;
    public function handleDelete(Comment $comment);
    public function handleUpdate(Comment $comment, CommentDTO $commentDto): Comment;


}
