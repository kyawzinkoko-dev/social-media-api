<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
   
    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

   
    public function findById(int $id): ?Comment
    {
        return Comment::find($id);
    }

   
    public function getByPostId(int $postId)
    {
        return Comment::where('post_id', $postId)
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->get();
    }

   
    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }
}
