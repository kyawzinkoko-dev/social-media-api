<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    
    public function show(): JsonResponse
    {
        $userId = Auth::id();
        $profile = $this->profileService->getProfile($userId);

        return response()->json($profile, 200);
    }
}
