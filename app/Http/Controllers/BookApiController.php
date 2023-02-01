<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BookApiController extends Controller
{
    public function index($author_id)
    {
        $books = Book::where('user_id', $author_id)->where('status', '1')
        ->where('deleted_at', null)->paginate(10);

        return BookResource::collection($books);
    }

    public function show($book_id)
    {
        $book = Book::findOrFail($book_id);
        return new BookResource($book);
    }
    
    public function update($book_id)
    {
        return response()->json(["message" => "Not implemented yet!"]);
    }
    
    public function view($id)
    {
        $book = Book::findOrFail($id);
        
        $validator = Validator::make(request()->all(), [
            'device_id' => 'required|string',
            'user_id' => 'integer',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 203,
                'message' => $validator->errors(),
            ]);
        } else {
            $user_id = request()->user_id ? request()->user_id : 0;
            $device_id = request()->device_id;
            
            $checkBook = DB::table('book')
                ->where('id', $id)
                ->exists();
            
            if (!$checkBook && $user_id != 0) {
                return response()->json([
                    'status' => 203,
                    'message' => 'Invalid book_id',
                ]);
            }
            
            $bookViewsCount = DB::table('books_view_count')
                      ->where('book_id', $book->id)
                      ->where('device_id', $device_id)
                      ->where('logged_in_user_id', $user_id)
                      ->count();
                      
            if($bookViewsCount == 0){
                DB::table('books_view_count')
                     ->insert(array(
                        'device_id' => $device_id, 
                        'book_id' => $book->id,
                        'logged_in_user_id' => $user_id,
                        ));
                
                $book_view_count = DB::table('books_view_count')
                                ->where('book_id', $book->id)->count();
                                    
                $amt = 0.002;
                $type = 'book';
                $date = date("Y-m-d");
            
                DB::table('transaction')->insert(array(
                          'user_id' => $book->id, 
                          'amount' => $amt, 
                          'type' => $type,
                          'on_views' => $book_view_count,
                          'date' => $date,
                      ));
            
                DB::table('users')
                    ->where('id', $user_id)
                    ->increment('amount', $amt);
                
                DB::table('users')
                    ->where('admin', 1)
                    ->increment('amount', $amt);
                    
                return response()->json([
                    "status" => 200,
                    "message" => "Viewed successfully",
                ]);
            }
            return response()->json([
                "status" => 200,
                "message" => "Already viewed",
                ]);
        }
    }
}
