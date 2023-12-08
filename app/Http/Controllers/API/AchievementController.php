<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AchievementRequest;
use App\Models\Achievement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(): JsonResponse
    {
        $achievements = Achievement::with('employee')->get();
        return $this->apiSuccessResponse('Achievement list', $achievements);
    }

    public function store (AchievementRequest $request): JsonResponse
    {
        $achievement = Achievement::create($request->validated());
        return $this->apiSuccessResponse('Achievement is created', $achievement);
    }
}
