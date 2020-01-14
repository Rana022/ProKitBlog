<?php

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

Route::get('/', 'HomeController@index')->name('home');
Route::post('subscriber', 'SubscriberController@store')->name('subscriber.store');
Route::get('post/{slug}', 'PostController@post')->name('post.details');
Route::get('posts', 'PostController@allPost')->name('post.all');
Route::get('category/{slug}posts/', 'PostController@PostByCategory')->name('category.posts');
Route::get('tag/{slug}posts/', 'PostController@PostByTag')->name('tag.posts');
Route::get('search', 'SearchController@search')->name('search');
Route::get('profile/{username}', 'AuthorController@profile')->name('author.profile');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
//Admin
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('settings', 'SettingsController@index')->name('settings');

    Route::get('comments', 'CommentController@store')->name('comment.store');
    Route::delete('comment/{id}/destroy', 'CommentController@destroy')->name('comment.destroy');

    Route::put('update-profile', 'SettingsController@updateProfile')->name('profile.update');
    Route::put('update-password', 'SettingsController@updatePassword')->name('password.update');
    Route::resource('tag', 'TagController');
    Route::resource('category', 'CategoryController');
    Route::resource('post', 'PostController');
    Route::get('pending/post', 'PostController@pendingPost')->name('post.pending');
    Route::put('/post/{id}/approve', 'PostController@approvePost')->name('post.approve');
    Route::get('/subscriber/index', 'SubscriberController@index')->name('subscriber.index');
    Route::delete('/subscriber/{id}/destroy', 'SubscriberController@destroy')->name('subscriber.destroy');

    //author
    Route::get('authors', 'AuthorController@index')->name('author.index');
    Route::delete('author/{id}/destroy', 'AuthorController@destroy')->name('author.destroy');


});

//Author
Route::group(['as' => 'author.', 'prefix' => 'author', 'namespace' => 'Author', 'middleware' => ['auth', 'author']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::put('update-profile', 'SettingsController@updateProfile')->name('profile.update');
    Route::put('update-password', 'SettingsController@updatePassword')->name('password.update');
    Route::resource('post', 'PostController');

    Route::get('comments', 'CommentController@store')->name('comment.store');
    Route::delete('comment/{id}/destroy', 'CommentController@destroy')->name('comment.destroy');

});

//Auth
Route::group(['middleware'=>['auth']], function () {
  Route::post('favourite/{id}/add', 'FavoriteController@add')->name('favourite.post');
  Route::post('comment/{post}/', 'CommentController@store')->name('comment.store');
});

View::composer('layouts.frontend.partial.footer', function($view) {
    $categories = App\Category::all();
    $view->with('categories',$categories);
});
