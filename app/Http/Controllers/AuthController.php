<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

   
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $this->authService->register($request->validated());

        return response()->json($data, 201);
    }

  
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->authService->login($request->validated());

        if (!$data) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json($data, 200);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
