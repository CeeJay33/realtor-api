<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;



// Route::resource('users', UsersController::class);
Route::get('users/search/{name}', [UsersController::class, 'search']);
Route::post("/register", [UsersController::class, "store"]);
Route::post("/login", [UsersController::class, "login"]);
Route::get("product/search/{ProductName}", [UsersController::class, "SearchProductByName"]);

Route::get("/", [UsersController::class, "index"]);
Route::get("/users/{id}", [UsersController::class, "show"]);


Route::middleware('auth:sanctum')->group(function () {
Route::put("/users/{id}", [UsersController::class, "update"]);
Route::delete("/users/{id}", [UsersController::class, "destroy"]);
Route::post("/logout", [UsersController::class, "logout"]);


});