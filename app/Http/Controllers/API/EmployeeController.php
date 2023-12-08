<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller {
    public function index(): JsonResponse
    {
        $employee = Employee::query()
        ->with('department', 'achievement')
        ->orderByDesc('id')
        ->paginate(5);
        return $this->apiSuccessResponse('Employee list', $employee);
    }

    public function show(Employee $employee): JsonResponse
    {
        $employee->load('department', 'achievement');
        return $this->apiSuccessResponse('Employee list', $employee);
    }

    public function store(EmployeeRequest $request): JsonResponse
    {
        $employee = Employee::create($request->except('achievement_id'));
        $employeeIds = $request->achievement_id;
        $employee->achievement()->attach($employeeIds);

        return $this->apiSuccessResponse('Employee is created', $employee);
    }

    public function update(Request $request, Employee $employee): JsonResponse
    {
        $employee->update($request->except('achievement_id'));
        $employeeIds = $request->achievement_id;
        $employee->achievement()->sync($employeeIds);

        return $this->apiSuccessResponse('Employee is updated', $employee);
    }

    public function delete(Employee $employee): JsonResponse
    {
        $employee->achievement()->detach();
        $employee->delete();

        return $this->apiSuccessResponse('Employee is deleted');
    }

    public function employeeSearch(Request $request): JsonResponse
    {
        $terms = '%'.$request->search.'%';
        $employee = Employee::query()
        ->where('name', 'LIKE', $terms)
        ->orWhere('phone', 'LIKE', $terms)
        ->orderByDesc('id')
        ->get();

        if($employee->isEmpty()){
            return $this->apiErrorResponse('Data not found!');
        }
          $employee->load('department', 'achievement');
        return $this->apiSuccessResponse('Employee search result', $employee);
    }
}
