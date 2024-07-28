<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;


Route::get('/categories',[ CategoryController::class, 'getCategories' ])->middleware('api');
Route::post('/category',[ CategoryController::class, 'postCategory' ])->middleware('api');
Route::delete('/category',[ CategoryController::class, 'deleteCategory' ])->middleware('api');
