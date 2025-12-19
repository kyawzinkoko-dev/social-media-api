<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $posts = $this->postService->getAllPosts($perPage);

        return response()->json($posts, 200);
    }

  
    public function store(PostRequest $request): JsonResponse
    {
        $userId = Auth::id();
        $post = $this->postService->createPost($request->validated(), $userId);

        return response()->json($post, 201);
    }

  
    public function update(PostRequest $request, int $id): JsonResponse
    {
        $userId = Auth::id();
        $post = $this->postService->findPost($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $updatedPost = $this->postService->updatePost($post, $request->validated(), $userId);

        if (!$updatedPost) {
            return response()->json(['error' => 'You are not authorized to edit this post'], 403);
        }

        return response()->json($updatedPost, 200);
    }

    
    public function myPosts(Request $request): JsonResponse
    {
        $userId = Auth::id();
        $perPage = $request->input('per_page', 15);
        $posts = $this->postService->getUserPosts($userId, $perPage);

        return response()->json($posts, 200);
    }
}
