<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function() {
    // Get all authors
    Route::get('/authors', 'AuthorApiController@index');
    
    // Get an author by id
    Route::get('/author/{id}', 'AuthorApiController@show');
    
    // Get recently added authors
    Route::get('/authors/new_authors', 'AuthorApiController@newAuthors');
    
    // Save a view on an author's profile
    Route::post('/authors/view/{id}', 'AuthorApiController@view');
    
    // Get all books by author
    Route::get('/books/{author_id}', 'BookApiController@index');
    
    // Show a specific book by id
    Route::get('/book/{book_id}', 'BookApiController@show');
    
    // Save a view on an author's book
    Route::post('/books/view/{id}', 'BookApiController@view');
    
    // Get all chapters by book
    Route::get('/chapters/{book_id}', 'ChapterApiController@index');
    
    // Get a specific chapter by id
    Route::get('/chapter/{chapter_id}', 'ChapterApiController@show');
    
    // Search
    Route::get('/search/authors/{query}', 'AuthorApiController@search');
    Route::get('/search/books/{query}', 'BookApiController@search');
    
    // Create a new user
    Route::post('/user/new', 'UserApiController@store');
});


// Get allowed scopes for a user
Route::post('/user/scopes', 'UserApiController@getScopes');

Route::middleware('auth:api')->group(function() {
    
    // Get current user
    Route::get('/user', 'UserApiController@index');
    
    // Create a book
    //Route::middleware('scopes:book:create')->post('/v1/books', 'BookApiController@store');
                   
    // Edit a book
    //Route::middleware('scope:book:edit-own,book:edit-any')->patch('/v1/book/{id}', 'BookApiController@store');
            
    // Create a chapter
    //Route::middleware('scopes:chapter:create')->post('/v1/chapters', 'ChapterApiController@store');
            
    // Edit a chapter
    //Route::middleware('scope:chapter:edit-own,chapter:edit-any')->patch('/v1/chapter/{id}', 'ChapterApiController@update');
    
});
