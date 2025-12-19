<?php

namespace App\Services;

use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;

class CommentService
{
    protected $commentRepository;
    protected $postRepository;

    public function __construct(
        CommentRepository $commentRepository,
        PostRepository $postRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
    }

    
    public function createComment(int $postId, array $data, int $userId): ?Comment
    {
       
        $post = $this->postRepository->findById($postId);
        if (!$post) {
            return null;
        }

        $data['post_id'] = $postId;
        $data['user_id'] = $userId;

        return $this->commentRepository->create($data);
    }

   
    public function getPostComments(int $postId)
    {
        return $this->commentRepository->getByPostId($postId);
    }
}
