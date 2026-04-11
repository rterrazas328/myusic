<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\ResourcesController;


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//root route
Route::get('/', [GuestController::class, 'index']);

//user routes
Route::get('/home', [UserController::class, 'index']);
Route::get('/profile',[UserController::class, 'getProfile']);
Route::post('/saveprofile',[UserController::class, 'saveProfile']);
Route::post('/saveprofilepic',[UserController::class, 'savePicture']);
Route::post('/saveaboutme',[UserController::class, 'saveAboutMe']);

//admin routes
Route::get('/admin',[AdminController::class, 'adminPage']);
Route::post('/admin', [AdminController::class, 'updateRoles']);

//music routes
Route::get('/tracks', [MusicController::class, 'getTracks']);
Route::get('/editplaylist/{id}', [MusicController::class, 'editPlaylist']);
Route::get('/playlists', [MusicController::class, 'getPlaylists']);
Route::get('/createplaylist', [MusicController::class, 'getCreatePlaylist']);
Route::post('/savetrack', [MusicController::class, 'saveTrack']);
Route::post('/deletetrack', [MusicController::class, 'deleteTrack']);
Route::post('/saveplaylist/{id?}', [MusicController::class, 'savePlaylist']);
Route::post('/deleteplaylist', [MusicController::class, 'deletePlaylist']);
Route::post('/editplaylist', [MusicController::class, 'editPlaylist']);

//resource routes
Route::get('/image', [ResourcesController::class, 'loadImage']);
Route::get('/audio/{id}', [ResourcesController::class, 'loadAudio']);

//guest routes
Route::get('/username', [GuestController::class, 'getUserName']);
Route::post('/username', [GuestController::class, 'postUserName']);


/*Route::get('/', function () {
    return view('welcome');
});*/
