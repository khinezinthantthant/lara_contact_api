<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SearchRecordsController;
use App\Http\Middleware\ApiTokenCheck;
use App\Models\Favorite;
use App\Models\SearchRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResource("contact",ContactController::class);





Route::prefix("v1")->group(function () {

    Route::middleware('auth:sanctum')->group(function () {

        Route::apiResource('contact', ContactController::class);
        Route::apiResource("search-record",SearchRecordsController::class);

        Route::controller(FavoriteController::class)->group(function(){
            Route::post("favorite/{id}", "store")->name("store");
            Route::get("favorite", "index")->name("index");
            Route::delete("favorite/{id}", "destroy")->name("destroy");
        });


        Route::controller(SearchRecordsController::class)->group(function(){
            Route::get('search-record',"index")->name("index");
            Route::delete("search-record/{id}","destroy")->name("destroy");
        });

        Route::controller(ApiAuthController::class)->group(function(){
            Route::post("logout", 'logout');
            Route::post("logout-all",'logoutAll');
            Route::get("devices",'devices');
        });

        Route::controller(ContactController::class)->group(function(){
            Route::delete('contact-force-delete/{id}',"forceDelete")->name("forceDelete");
            Route::get('contact-trash','trash')->name("trash");
            Route::post("contact-restore/{id}","restore")->name("restore");
            // Route::get('restore-all',"restoreAll")->name("restoreAll");
        });

    });

    Route::post("register", [ApiAuthController::class, 'register']);
    Route::post("login", [ApiAuthController::class, 'login']);
});



// Route::post("register",[ApiAuthController::class,'register']);
