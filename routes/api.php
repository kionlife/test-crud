<?php

use App\Http\Controllers\API\AchievementController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/login', function(){
    return response()->json([
        'message'   => 'Unauthorized',
    ]);
})->name('login');

Route::prefix('v1')->group(function(){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware('auth:api')->group(function(){
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/auth-user', [AuthController::class, 'authUser']);

        Route::prefix('employee')->group(function(){
            Route::post('/create', [EmployeeController::class, 'store']);
            Route::get('/list', [EmployeeController::class, 'index']);
            Route::get('/show/{employee}', [EmployeeController::class, 'show']);
            Route::post('/update/{employee}', [EmployeeController::class, 'update']);
            Route::get('/delete/{employee}', [EmployeeController::class, 'delete']);
            Route::get('/search', [EmployeeController::class, 'employeeSearch']);
        });
       
        Route::post('/department/create', [DepartmentController::class, 'store']);
        Route::get('/department/list', [DepartmentController::class, 'index']);

        Route::post('/achievement/create', [AchievementController::class, 'store']);
        Route::get('/achievement/list', [AchievementController::class, 'index']);
    });
});


