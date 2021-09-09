<?php

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


Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin'], function (){
    Route::get('', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.index');
    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
    Route::group(['prefix' => 'users'], function (){
        Route::get('create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
        Route::post('create', [App\Http\Controllers\Admin\UserController::class, 'store']);
    });
    Route::group(['prefix' => 'posts'], function (){
        Route::get('create', [App\Http\Controllers\Admin\PostController::class, 'create'])->name('admin.posts.create');
        Route::post('create', [App\Http\Controllers\Admin\PostController::class, 'store']);
        Route::get('', [App\Http\Controllers\Admin\PostController::class, 'show'])->name('admin.posts.show');
        Route::get('{id}', [App\Http\Controllers\Admin\PostController::class, 'view'])->name('admin.posts.view');
        Route::get('category/{id}', [App\Http\Controllers\Admin\PostController::class, 'viewCategoryPosts'])->name('admin.category.posts.show');
        Route::get('user/{id}', [App\Http\Controllers\Admin\PostController::class, 'viewUserPosts'])->name('admin.user.posts.show');
        Route::get('edit/{id}', [App\Http\Controllers\Admin\PostController::class, 'edit'])->name('admin.posts.edit');
        Route::post('edit/{id}', [App\Http\Controllers\Admin\PostController::class, 'update']);
        Route::get('delete/{id}', [App\Http\Controllers\Admin\PostController::class, 'delete'])->name('admin.posts.delete');
    });
});



