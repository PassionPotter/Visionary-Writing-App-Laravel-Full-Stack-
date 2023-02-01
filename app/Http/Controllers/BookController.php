<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Image; 
use Auth;
use App\Book;
use App\Chapter;
use Session;
use Carbon\Carbon;
use DB;

class BookController extends Controller

{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public

	function index()
	{
		//echo "testing12389"; exit();
		$id = Auth::user()->id;

		$searchTerm = isset($_REQUEST['search_text']) ? $_REQUEST['search_text'] : '';

		if (isset($_REQUEST['search']) && $_REQUEST['search'] == 'Reset') {
			$searchTerm = '';
		}



		if ($searchTerm != '') {
		

			$all_books = Book::with('user')->whereHas('user', function ($query) use ($searchTerm) {
				$query->where('name', 'LIKE', '%'.$searchTerm.'%');
			});
			
			$all_books = $all_books->orWhere('description', 'LIKE', '%'.$searchTerm.'%');
			$all_books = $all_books->orWhere('title', 'LIKE', '%'.$searchTerm.'%');
			$all_books = $all_books->orWhere('genre', 'LIKE', '%'.$searchTerm.'%')->paginate(20);
		} else {
		
			$all_books = Book::where('status', 1)
			->orderBy('created_at', 'dsc')
		    ->paginate(20);
		    // old query
			// $all_books = Book::orderBy("created_at",'dsc')->paginate(5);



		}



		$date = Carbon::parse($all_books['created_at']);

		$createdAt= $date->format('Y M d');
		$Users = User::find($id)->books()->paginate(20);

		// return view('admin.books.index', compact('Users', 'all_books','createdAt', 'searchTerm'));
		return view('admin.books.index', compact('Users', 'all_books','createdAt', 'searchTerm'));


	}

	public

	function draft_book()
	{
		$id = Auth::user()->id;
		$all_books = User::all();
		$Users = User::find($id)->books;
		return view('admin.books.draft', compact('Users', 'all_books'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public

	function create()
	{
		$all_books = User::all();
		return view('admin.books.create', compact('all_books'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public

	function store(Request $Request, $status)
	{

	//dd($Request->all());

		if ($Request->hasFile('book_cover'))
		{
			$this->validate($Request, ['book_cover' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 'title' => 'required','bookOrder' => 'required|integer']);
			$input['title'] = $Request->title;
			$input['book_order'] = $Request->bookOrder;
			$input['genre']=$Request->bookGenre;
			$input['description'] = $Request->description;
			$input['status'] = $status;
			$Request->changeAuthor ? $input['user_id'] = $Request->changeAuthor : $input['user_id'] = Auth::user()->id;
			$input['slug'] = str_slug($Request->title);
			$image = $Request->file('book_cover');
			$input['book_cover'] = time() . '_' . str_random(6) . '.' . strtolower($image->getClientOriginalExtension());
			Image::make($image)->save(public_path('books/uploads/') . $input['book_cover'], 100);
			Book::create($input);
			Session::flash('success', 'Book successfuly created');
			return redirect()->back();
		}
		else
		{
			$this->validate($Request, ['title' => 'required','bookOrder' => 'required|integer']);
			$input['title'] = $Request->title;
			$input['book_order'] = $Request->bookOrder;
			$input['genre']=$Request->bookGenre;
			$input['description'] = $Request->description;
			$input['status'] = $status;
			if ($Request->changeAuthor)
			{
				$input['user_id'] = $Request->changeAuthor;
			}
			else
			{
				$input['user_id'] = Auth::user()->id;
			}

			$input['slug'] = str_slug($Request->title);
			Book::create($input);
			Session::flash('success', 'Book successfuly created');
			return redirect()->back();
		}
	}

	public function save_book_as_draft(Request $Request, $status)
	{
		if ($Request->ajax())
		{
			$this->store($Request, $status);
		}
	}

	public function update_book_as_draft(Request $Request,$id, $status)
	{
		if ($Request->ajax())
		{
			$this->update($Request,$id, $status);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public

	function show($id)
	{

		//

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public

	function edit($id)
	{
		$Book = Book::find($id);
		$all_books = User::all();
		return view('admin.books.edit', compact('Book', 'all_books'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public

	function update(Request $Request, $id,$status)
	{
		
		$book_author = Book::find($id);
		if ($Request->hasFile('book_cover'))
		{
			$this->validate($Request, ['book_cover' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 'title' => 'required','bookOrder' => 'required|integer']);
			$input['created_at'] = $Request->created_at;
			$input['title'] = $Request->title;
			$input['book_order'] = $Request->bookOrder;
			$input['genre']=$Request->bookGenre;
			$input['description'] = $Request->description;
			$input['status'] = $status;
			if ($Request->has('changeAuthor')){
				$Request->changeAuthor =="" ? $input['user_id'] = Auth::user()->id : $input['user_id'] = $Request->changeAuthor;
			}
			file_exists(public_path('books/uploads/'.$book_author->book_cover)) ? unlink(public_path('books/uploads/'.$book_author->book_cover)) : 'Something went wrong';
			$input['slug'] = str_slug($Request->title);
			$image = $Request->file('book_cover');
			$input['book_cover'] = time() . '_' . str_random(6) . '.' . strtolower($image->getClientOriginalExtension());
			Image::make($image)->save(public_path('books/uploads/') . $input['book_cover'], 100);
			$book_author->update($input);
			Session::flash('success', 'Book successfuly updated');
			return redirect()->back();
		}
		else
		{
			$this->validate($Request, ['title' => 'required','bookOrder' => 'required|integer']);
			$input['title'] = $Request->title;
			$input['book_order'] = $Request->bookOrder;
			$input['genre']=$Request->bookGenre;
			$input['created_at'] = $Request->created_at;
			$input['description'] = $Request->description;
			$input['status'] = $status;
			if ($Request->has('changeAuthor')){
				if ($Request->changeAuthor =="")
				{
					$input['user_id'] = Auth::user()->id;
				}
				else
				{

					$input['user_id'] = $Request->changeAuthor;

				}
			}
			
			$input['slug'] = str_slug($Request->title);
			$book_author = Book::find($id);
			$book_author ->update($input);
			Session::flash('success', 'Book successfuly created');
			return redirect()->back();
		}
		
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public

	function bookStatus($id, $status)
	{
		$book = Book::find($id);
		$book->status = $status;
		$book->save();
	}

	public

	function publish($id, $status)
	{
		$this->bookStatus($id, $status);
		Session::flash('success', 'book successfuly published');
		return redirect()->back();
	}

	public

	function save_published_book_as_draft($id, $status)
	{
		$this->bookStatus($id, $status);
		Session::flash('success', 'book successfuly sent to draft');
		return redirect()->back();
	}

	public function destroyByIds(Request $request)
	{
		$data = $request->all();
		
		$id ="";
		foreach ($data['bookids'] as $key => $value) {
			$book = Book::find($value)->update(['status'=>0]);
		}
		// $id = rtrim($id, ", ");

		// echo $id;
		// $book = DB::table('book')
		// ->whereIn('id', (string)$id)
		// ->update(['status' => 0]);
		// ;

		Session::flash('success', 'books and content trashed successfuly');
		return "DONE";
	}
	function destroy($id)
	{
		$book = Book::find($id)->update(['complete'=>1]);
		//print_r($book);
		// foreach($book->Chapters as $trash_Chapters)
		// {
		// 	$trash_Chapters->delete();
		// }
		
		// $book->delete();
		Session::flash('success', 'book mark as complete successfuly');
		return redirect()->back();
	}
	
	function destroyy($id)
	{
		$book = Book::find($id)->update(['complete'=>0]);
		//print_r($book);
		// foreach($book->Chapters as $trash_Chapters)
		// {
		// 	$trash_Chapters->delete();
		// }
		
		// $book->delete();
		Session::flash('success', 'book unmark successfuly');
		return redirect()->back();
	}

	public

	function trashed()
	{
		$id = Auth::user()->id;

		// $all_books = Book::onlyTrashed()->paginate(19);
		$all_books = Book::where('status',"=",0)->get();
		
		$Users = User::find($id)->books()->get();
		
		return view('admin.books.trashed', compact('Users', 'all_books'));
	}

	public

	function restore($id)
	{
		Book::withTrashed()->where('id', $id)->restore();
		Chapter::withTrashed()->where('book_id', $id)->restore();
		Session::flash('success', 'Book restored!');
		return redirect()->route('books');
	}

	public

	function delete($id)
	{
		$book = Book::withTrashed()->where('id', $id)->first();
		if (Chapter::withTrashed()->where('book_id', $id)->first())
		{
			$chapter = Chapter::withTrashed()->where('book_id', $id)->first();
			file_exists(public_path('books/uploads/'.$book->book_cover)) ? unlink(public_path('books/uploads/'.$book->book_cover)) : 'Something went wrong';
			$chapter->forceDelete();
			Session::flash('success', 'Book and chapters permanently deleted!');
			return redirect()->route('trashed.books');
		}
		else
		{
			file_exists(public_path('books/uploads/'.$book->book_cover)) ? unlink(public_path('books/uploads/'.$book->book_cover)) : 'Something went wrong';
			$book->forceDelete();
			Session::flash('info', 'No chapters were found, a book has been deleted instead');
			return redirect()->route('trashed.books');
		}
	}
}
