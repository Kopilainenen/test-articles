<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/tags', [ApiController::class, 'createTag']);
Route::put('/tags/{tagId}', [ApiController::class, 'editTag']);

Route::post('/articles', [ApiController::class, 'createArticle']);
Route::put('/articles/{articleId}', [ApiController::class, 'editArticle']);
Route::delete('/articles/{articleId}', [ApiController::class, 'deleteArticle']);

Route::get('/articles', [ApiController::class, 'getArticles']);
Route::get('/articles/{articleId}', [ApiController::class, 'getArticleById']);
