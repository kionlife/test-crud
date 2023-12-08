<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(): JsonResponse
    {
        $departments = Department::with('employee')->get();
        return $this->apiSuccessResponse('Department list', $departments);
    }

    public function store (DepartmentRequest $request) : JsonResponse
    {
        $department = Department::create($request->validated());
        return $this->apiSuccessResponse('Department is created', $department);
    }
}
