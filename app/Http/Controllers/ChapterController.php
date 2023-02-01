<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chapter;
use App\Book;
use App\User;
use Auth;
use Excel;
use Session;
use DB;
class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //$chapters= Book::find($id)->Chapters()->orderBy('created_at','asc')->paginate(15);
	    $chapters= Book::find($id)->Chapters()->paginate(15);
       return view('admin.chapters.index',compact('chapters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $book_id = url()->current();
        $id_auth = explode("/",$book_id);

//         echo "<pre>testing"; print_r($id_auth); exit();
        if (count($id_auth) > 5) {

            $book_id = $id_auth[6];
        }else{
            $book_id="";
        }
 

      $id = Auth::user()->id;
        $all_authors_books = User::all();


        if(Auth::user()->admin){
            
            $all_books = DB::table('book')
            ->orderBy('title', 'ASC')
            ->get();
        }
        else{
            // echo "<pre>ff"; print_r($book_id); exit();
            $user_books = DB::table('book')
            ->where('user_id', $id)
            ->where('status', 1)
            ->orderBy('title', 'ASC')
            ->get();

            if ($book_id !='') {
            $chap_book = DB::table('book')
            ->where('id', $book_id)
            ->where('status', 1)
            ->get();
            }
        }


       
        $books = User::find($id)->books;

        if($books->count()== 0 && !Auth::user()->admin)
        {

            Session::flash('info','you must have a book before attempting to create a chapter ');
            return redirect()->back();
        }

        // echo "<pre>"; print_r($chap_book[0]->id); exit();

           // return view('admin.chapters.create',compact('books','all_authors_books', 'all_books', 'user_books'));
        
        return view('admin.chapters.create',compact('books','book_id','all_authors_books', 'user_books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $Request)
    {
        
	    $rules = [
	   'title'=> 'required',
	   'chapter_content' => 'required',
	   'bookId'=> 'required|not_in:14|integer'
		];
	
	    $customMessages = [
	    'title.required' => 'Title cannot be blank',
	    'chapter_content.required' => 'Please add chapter content',
	    'bookId.required' => 'Please select a book',
	    'bookId.not_in' => 'Please select a book',
	    'bookId.integer' => 'Please select a book',
        //'title.regex' => 'Title Special character Not allow'
	    ];
	
	$this->validate($Request, $rules, $customMessages);
        $input['title']=$Request->title;
        $input['book_id'] = $Request->bookId;
        $input['status'] =1;
        $input['chapter_content']=$Request->chapter_content;
        $input['slug']=str_slug($Request->title);
        Chapter::create($input);
        Session::flash('success','Chapter created successfuly');
       return redirect()->back();
    }

        public function draft(Request $Request)
    {
        if($Request->ajax())
        {
            if($Request->title==$Request->title)
            {
                 $this->validate($Request,['title'=>'required','chapter_content' =>'required']);
                $input['title']=$Request->title;
                $input['book_id'] = $Request->book_id;
                $input['status'] =0;
                $input['chapter_content']=$Request->chapter_content;
                $input['slug']=str_slug($Request->title);
                Chapter::create($input);
                return response()->json(['message' => 'Chapter successfuly saved to draft']);
             return redirect()->back();
             }

        }

    }

    public function publish($id)
    {
        $publish = Chapter::find($id);
        $publish->status=1;
        $publish->save();
        Session::flash('success','chapter successfuly published');
        return redirect()->back();
    }

       public function change_status_to_draft($id)
    {
        $publish = Chapter::find($id);
        $publish->status=0;
        $publish->save();
        Session::flash('success','chapter successfuly put to draft');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $chapterContents = Chapter::where('id',$id)->get();
    return view('admin.chapters.show',compact('chapterContents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $chapter = Chapter::find($id);
        return view('admin.chapters.edit',compact('chapter',$chapter));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $chapter = Chapter::find($id);
        $chapter->title = $request->title;
        $chapter->chapter_content = $request->chapter_content;
        $chapter->slug = str_slug($request->title);
        $chapter->created_at= $request->created_at;
        $chapter->save();
        Session::flash('success','Chapter updated successfuly');
        return redirect()->back();
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Chapter::find($id)->delete();
        Session::flash('success','Chapter deleted successfuly');
        return redirect()->back();
    }

    public function import(Request $request)
    {
     
         if($request->file('chaptersFile') && $request->ajax())
      { 
                $path = $request->file('chaptersFile')->getRealPath();
                $data = Excel::load($path, function($reader)
          {
                })->get();

          if(!empty($data) && $data->count())
          {
            foreach ($data as $row)
            {
              if(!empty($row))
              {
                $dataArray[] =
                   [
                  'title' => $row["title"],
                  'chapter_content' => $row["content"],
                  'book_id' => $request->book_id,
                  'slug' => $row["title"],
                  'created_at' => $row["date"],
                  'status' =>1
                ];
              }
          }
          if(!empty($dataArray))
          {
              Chapter::insert($dataArray);
             return response('success');
             return back();
           }
         }
       }
    }
}
