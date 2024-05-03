<?php

use App\Http\Controllers\AuthController;
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

Route::post('/user/login', [AuthController::class, 'login']);
Route::post('/user/registrasi', [AuthController::class, 'registrasi']);


Route::get('/album/user/{idUser}', [App\Http\Controllers\AlbumController::class, 'index']);
Route::get('/album/{idAlbum}', [App\Http\Controllers\AlbumController::class, 'show']);
Route::post('/album', [App\Http\Controllers\AlbumController::class, 'store']);
Route::patch('/album/{idAlbum}', [App\Http\Controllers\AlbumController::class, 'update']);
Route::delete('/album/{idAlbum}', [App\Http\Controllers\AlbumController::class, 'destroy']);


Route::get('/foto ', [App\Http\Controllers\FotoController::class, 'index']);
Route::get('/getFoto/{file}', [App\Http\Controllers\FotoController::class, 'getFoto']);
Route::get('/getFotoById/{id}', [App\Http\Controllers\FotoController::class, 'getFotoById']);
Route::get('/foto/album/{idAlbum}', [App\Http\Controllers\FotoController::class, 'showFotoAlbum']);
Route::get('/foto/{idFoto}', [App\Http\Controllers\FotoController::class, 'show']);
Route::post('/foto', [App\Http\Controllers\FotoController::class, 'store']);
Route::patch('/foto/{idFoto}', [App\Http\Controllers\FotoController::class, 'update']);
Route::delete('/foto/{idFoto}', [App\Http\Controllers\FotoController::class, 'destroy']);

Route::apiResource('komentar', App\Http\Controllers\KomentarController::class);

Route::post('/like', [App\Http\Controllers\LikeController::class, 'toggleLike']);
Route::get('/like/check/{id_user}/{id_foto}', [App\Http\Controllers\LikeController::class, 'checkLike']);

Route::post('/komentar', [App\Http\Controllers\KomentarController::class, 'store']);
Route::delete('/komentar/{id}', [App\Http\Controllers\KomentarController::class, 'destroy']);


