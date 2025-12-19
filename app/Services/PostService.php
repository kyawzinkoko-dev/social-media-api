<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Storage;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Create a new post.
     *
     * @param array $data
     * @param int $userId
     * @return Post
     */
    public function createPost(array $data, int $userId): Post
    {
        $data['user_id'] = $userId;

        // Handle image upload if present
        if (isset($data['image']) && $data['image']) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        return $this->postRepository->create($data);
    }

   
    public function updatePost(Post $post, array $data, int $userId): ?Post
    {
        
        if ($post->user_id !== $userId) {
            return null;
        }

       
        if (isset($data['image']) && $data['image']) {
            if ($post->image) {
                Storage::delete($post->image);
            }
            $data['image'] = $this->uploadImage($data['image']);
        }

        return $this->postRepository->update($post, $data);
    }

   
    public function getAllPosts(int $perPage = 15)
    {
        return $this->postRepository->getAllWithCounts($perPage);
    }

   
    public function getUserPosts(int $userId, int $perPage = 15)
    {
        return $this->postRepository->getByUserId($userId, $perPage);
    }

   
    public function findPost(int $id): ?Post
    {
        return $this->postRepository->findById($id);
    }

   
    protected function uploadImage($image): string
    {
        return $image->store('posts', 'public');
    }
}
