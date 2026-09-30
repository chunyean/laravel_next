<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task_Controller;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\RequestTiming;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    //new method shortcut to do CRUL
    Route::get('/todos', [Task_Controller::class, 'index2']);
    Route::post('/todos', [Task_Controller::class, 'store']);
    Route::post('/todos/{params}', [Task_Controller::class, 'show']);
    Route::patch('/todos/{params}', [Task_Controller::class, 'update2']);
    Route::delete('/todos/{params}', [Task_Controller::class, 'delete2']);

    //old method to do CRUL
    Route::get('/todos2', [Task_Controller::class, 'index2']);
    Route::post('/todos2', [Task_Controller::class, 'store2']);
    Route::get('/todos2/{params}', [Task_Controller::class, 'show2']);
    Route::delete('/todos2/{params}', [Task_Controller::class, 'delete2']);
    Route::patch('/todos2/{params}', [Task_Controller::class, 'update2']);


    Route::post('/logout', [AuthController::class, 'logout']);

});

