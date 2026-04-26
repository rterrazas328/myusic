<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\Mail;

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

Route::middleware('guest')->group(function () {
//root route
Route::get('/', [GuestController::class, 'index']);
//guest routes
Route::get('/username', [GuestController::class, 'getUserName']);
Route::post('/username', [GuestController::class, 'postUserName']);
});


Route::middleware('auth')->group(function () {
//user routes
Route::get('/home', [UserController::class, 'index'])->name('home');
Route::get('/userprofile',[UserController::class, 'getProfile']);
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
});

Route::get('/test-mail', function () {
    try {
        Mail::raw('Mailgun test successful!', function ($message) {
            $message->to('rterrazas328@gmail.com')
                    ->subject('Mailgun Test');
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Email sent successfully!'
        ]);

    } catch (Exception $e) {

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString() // optional, but very useful
        ], 500);
    }
    /*Mail::raw('Mailgun test successful!', function ($message) {
        $message->to('rterrazas328@gmail.com')->subject('Mailgun Test');
    });

    return 'Sent!';*/
});


/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';







