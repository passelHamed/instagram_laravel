<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Models\User;
use Illuminate\Support\Facades\Route;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('user_profile' , ['username' => auth()->user()->username]);
    })->name('dashboard');
});


Route::get('{username}' , function ($username){
    $user = User::where('username' , $username)->first();
    $posts = $user->posts;
    if ($user == null){
        abort(404);
    }
    return view('profile' , ['profile' => $user , 'posts' => $posts]);
})->name('user_profile');


Route::resource('posts', postController::class);

Route::resource('comments', commentController::class);



