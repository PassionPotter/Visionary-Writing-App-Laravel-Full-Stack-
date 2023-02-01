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

// Route::get('/',function(){
//     echo "DONE";
// });
Route::get('/test',function(){
  return App\User::find(1)->profile;
});
Route::group(['prefix'=>'admin', 'middleware' => 'auth'],function(){

    Route::get('home', 'HomeController@admin_index')->name('admin-home');
    Route::post('/import','HomeController@import')->name('import');
    Route::get('/book/create','BookController@create')->name('book/create');

    Route::get('/monthlyearning', 'HomeController@monthlyEarning')->name('/monthlyearning');

    Route::get('/payment/form','PaymentController@paymentForm')->name('payment/form');
    Route::post('/payment/send','PaymentController@paymentAmount')->name('payment/send');
    Route::get('/payment/details', 'HomeController@paymentDetails')->name('/payment/details');

    //bank details
    Route::get('/bank/details', 'HomeController@bankDetails')->name('/bank/details');
    Route::get('/bank/add','HomeController@bankAddForm')->name('bank/add');
    Route::post('/bank/add','HomeController@bankAddDetails')->name('bank/add/details');
    Route::get('/bank/edit/{id}','HomeController@bankEditForm')->name('bank/edit');
    Route::post('/bank/update','HomeController@bankUpdateDetails')->name('bank/add/update');

    Route::get('/requestPayment/{id}','HomeController@requestPayment')->name('/requestPayment');
    

    Route::get('/books','BookController@index')->name('books');
    Route::get('/books/trashed','BookController@trashed')->name('trashed.books');
    Route::get('/restore/trashed/book/{id}','BookController@restore')->name('restore.trashed.book');
    Route::get('/delete/trashed/book/{id}','BookController@delete')->name('delete.trashed.book');
    Route::get('/edit/book/{id}','BookController@edit')->name('edit.book');
    Route::post('/book.update/{id}/{status}','BookController@update')->name('book/update');
    Route::get('/trash.book/{id}','BookController@destroy')->name('trash.book');
    Route::post('/book/store/{status}','BookController@store')->name('book/store');
    Route::get('publish/book/{id}/{status}','BookController@publish')->name('publish.book');
    Route::get('/chapter/create','ChapterController@create')->name('chapter/create');
    Route::post('/chapters/import','ChapterController@import')->name('chapters.import');
    Route::post('/chapter/draft','ChapterController@draft')->name('chapter/draft');
    Route::get('draft/books','BookController@draft_book')->name('draft/books');
    Route::post('save/book/as/draft/{status}','BookController@save_book_as_draft')->name('save_book_as_draft');
    Route::post('update/book/as/draft/{id}/{status}','BookController@update_book_as_draft')->name('update_book_as_draft');
    Route::get('save/published/book/as/draft/{id}/{status}',['uses' => 'BookController@save_published_book_as_draft','as' => 'save_published_book_as_draft']);
    Route::post('chapter/store','ChapterController@store')->name('chapter/store');
    Route::get('/BookChapters/{id}',['uses' => 'ChapterController@index', 'as' =>'BookChapters']);
    Route::get('/ReadChapter/{id}',['uses'=> 'ChapterController@show','as' => 'read.chapter']);
    Route::get('/EditChapter/{id}',['uses'=> 'ChapterController@edit','as' => 'edit.chapter']);
    Route::get('/publish/chapter/{id}',['uses' => 'ChapterController@publish', 'as' => 'publish.chapter']);
    Route::get('/draft/chapter/{id}',['uses' => 'ChapterController@change_status_to_draft', 'as' => 'draft.chapter']);
    Route::post('/update.chapter/{id}',['uses'=>'ChapterController@update', 'as' => 'update.chapter']);
    Route::get('/DeleteChapter/{id}',['uses'=> 'ChapterController@destroy','as' => 'delete.chapter']);
    Route::get('/users',['uses'=> 'UsersController@index','as' => 'users']);
    Route::get('user.create',['uses' => 'UsersController@create', 'as' =>'user.create']);
     Route::get('user.edit/{id}',['uses' => 'UsersController@edit', 'as' => 'user.edit']);
    Route::get('user.registered',['uses' => 'UsersController@registered', 'as' => 'user.registered']);
    Route::get('user.activate/{id}',['uses' => 'UsersController@activate', 'as' => 'user.activate']);
    Route::get('user.deactivate/{id}',['uses' => 'UsersController@deactivate', 'as' => 'user.deactivate']);
    Route::get('user.delete/{id}',['uses' => 'UsersController@delete', 'as' => 'user.delete']);
    Route::post('/users/import',['uses' => 'UsersController@importUsers', 'as' => 'users/import']);
    Route::post('user.store',['uses' => 'UsersController@store', 'as' =>'user.store']);
    Route::get('user.admin/{id}',['uses' => 'UsersController@admin','as' =>'user.admin']);
    Route::get('user.not-admin/{id}',['uses' => 'UsersController@not_admin','as' =>'user.not-admin']);
    Route::get('user/delete/{id}',['uses' => 'UsersController@destroy','as' =>'user.delete']);
    Route::get('user.profile/',['uses' => 'ProfilesController@index','as' =>'user.profile']);
    Route::post('user/profile/update/',['uses' => 'ProfilesController@update','as' =>'user/profile/update']);
    Route::post('user/profile/updateImage/',['uses' => 'ProfilesController@updateImage','as' =>'user/profile/updateImage']);
    Route::get('ads','adController@show')->name('ads');
    Route::get('ad/new','adController@index')->name('ad-new');
    Route::get('ad/restrict','adController@restrictAd')->name('ad-restrict');
    Route::post('ad/strict/add','adController@addNewstrict')->name('addNewstrict');
    Route::post('ad/strict/add/keyword','adController@addNewstrictKey')->name('addNewstrictKey');

  
    Route::get('ad/strict/links','adController@viewRlinks')->name('viewRlinks');
    Route::get('ad/strict/links/activate/{id}','adController@activaterLink')->name('activaterLink');
    Route::get('ad/strict/links/deactivate/{id}','adController@deactivaterLink')->name('deactivaterLink');
    Route::get('ad/strict/links/delete/{id}','adController@deleterLink')->name('deleterLink');
    
    Route::get('ad/strict/keywords','adController@viewRkeywords')->name('viewRkeywords');
    Route::get('ad/strict/keywords/activate/{id}','adController@activaterkey')->name('activaterkey');
    Route::get('ad/strict/keywords/deactivate/{id}','adController@deactivaterkey')->name('deactivaterkey');
    Route::get('ad/strict/keywords/delete/{id}','adController@deleterkey')->name('deleterkey');
    
    
    Route::post('store','adController@store')->name('store');
    Route::get('edit/ad/{id}','adController@edit')->name('edit');
    Route::post('update/ad/{id}','adController@update')->name('update');
    Route::get('delete/ad/{id}','adController@destroy')->name('delete');
    Route::get('activate/ad/{id}','adController@activate')->name('activate');
    Route::get('deactivate/ad/{id}','adController@deactivate')->name('deactivate');
    

});
    Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');
    Route::get('/faq', 'HomeController@faq')->name('faq');
    Route::get('/TERMS-AND-PRIVACY-POLICY', 'HomeController@tnpp')->name('tnpp');
    Route::get('/BECOME-A-VISIONARY-WRITINGS-AUTHOR', 'HomeController@register')->name('register-author');
    Route::post('submit/form','HomeController@submitForm')->name('submit-contact-form');
    Route::get('/contact', 'HomeController@contact')->name('contact');
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/about', 'HomeController@about')->name('about');
    Route::get('author/{author}/id/{id}', 'HomeController@display_authors_books')->name('author/books/author_id');
    Route::get('author/{author}/{auhthorId}/book/{book}/id/{id}', 'HomeController@display_book_chapters')->name('author/book/book_id');
    Route::get('author/{author}/{auhthorId}/book/{book}/bookId/{bookId}/chapter/{chapter}/id/{id}', 'HomeController@read_book')->name('author/book/chapter_id');
    Route::get('chapter/{slug}','HomeController@singleChapter')->name('single.chapter');
    /*Route::get('results',function(){
            $books = App\Book::whereHas('Chapters', function($query){
            $query->where('title', 'like', '%'.request('query').'%');
        })->orWhere('title','like','%'.request('query').'%')->get();
        $authors = App\User::where('name','like','%' . request('query') .'%')->get();

        return view ('frontend.results')
        ->with('authors',$authors)
        ->with('books',$books)
        ->with('query',request('query'));
    })->name('results');*/
     Route::get('results',function(){
            $books = App\Book::whereHas('Chapters', function($query){
            $query->where('title', 'like', '%'.request('query').'%');
        })->orWhere('title','like','%'.request('query').'%')->get();
        $authors = App\User::where('name','like','%' . request('query') .'%')
        ->where([
                'active' => 1,
                'verified' => 1,
            ])
        ->paginate(15);
       
        return view ('frontend.results')
        ->with('authors',$authors)
        ->with('books',$books)
        ->with('query',request('query'));
    })->name('results');
    /**/
     Route::post('comment/store','CommentController@store')->name('comment/store');
    Route::post('/customer/ajaxupdate', 'AjaxController@updateCustomerRecord');
    Route::post('/customer/ajaxupdateuser', 'AjaxController@updateCustomerRecordUser');
    /**/
Auth::routes();

