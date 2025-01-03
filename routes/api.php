<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\VerifyCsrfHeader;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::middleware([VerifyCsrfToken::class])->group(function () {
Route::post("/login", [UsersController::class, "login"]);
});
Route::post("/register", [UsersController::class, "store"]); 
Route::get("/", [UsersController::class, "index"]); 
Route::get("/users/{id}", [UsersController::class, "show"]);
Route::get("users/search/{name}", [UsersController::class, "search"]); 
Route::get("product/search/{ProductName}", [UsersController::class, "SearchProductByName"]);

Route::post('invalidate-sessions', function () {
    File::cleanDirectory(storage_path('framework/sessions'));

    DB::table('sessions')->truncate();

    session()->invalidate();
    Session::flush();

    return response()->json(['message' => 'All sessions invalidated successfully.']);
});

Route::middleware(['auth:sanctum', VerifyCsrfToken::class])->group(function () {
    Route::put("/users/{id}", [UsersController::class, "update"]); 
    Route::delete("/users/{id}", [UsersController::class, "destroy"]); 
    Route::post("/logout", [UsersController::class, "logout"]); 
    Route::get("/authStatus", [UsersController::class, "checkAuthStats"]);
});
