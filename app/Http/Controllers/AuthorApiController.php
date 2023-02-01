<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\AuthorResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthorApiController extends Controller
{
    public function index()
    {
        $users = User::where('admin','0')
        ->where('verified', '1')
        ->where('active', '1')
        ->paginate(10);
        
        return AuthorResource::collection($users);
    }
    
    public function show($id)
    {
        $author = User::findOrFail($id);
        return new AuthorResource($author);
    }
    
    public function view($id)
    {
        $author = User::findOrFail($id);
        
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
            
            $checkUser = DB::table('users')
                ->where('id', $user_id)
                ->exists();
            
            if (!$checkUser && $user_id != 0) {
                return response()->json([
                    'status' => 203,
                    'message' => 'Invalid user_id',
                ]);
            }
            
            $userViewsCount = DB::table('authors_view_count')
                      ->where('user_id', $author->id)
                      ->where('device_id', $device_id)
                      ->where('logged_in_user_id', $user_id)
                      ->count();
                      
            if($userViewsCount == 0){
                DB::table('authors_view_count')
                     ->insert(array(
                        'device_id' => $device_id, 
                        'user_id' => $author->id,
                        'logged_in_user_id' => $user_id,
                        ));
                
                $authors_view_count = DB::table('authors_view_count')
                                ->where('user_id',$author->id)->count();
                                    
                $amt = 0.01;
                $type = 'profile';
                $date = date("Y-m-d");
            
                DB::table('transaction')->insert(array(
                          'user_id' => $author->id, 
                          'amount' => $amt, 
                          'type' => $type,
                          'on_views' => $authors_view_count,
                          'date' => $date,
                      ));
            
                DB::table('users')
                    ->where('id', $author->id)
                    ->increment('amount', $amt);
                
                DB::table('users')
                    ->where('admin', 1)
                    ->increment('amount', $amt);
                    
                return response()->json([
                    "status" => 200,
                    "message" => "Viewed successfully",
                ]);
            } else {
                return response()->json([
                    "status" => 200,
                    "message" => "Already viewed",
                    ]);
            }
        }
    }
    
    public function search($query)
    {
        
    }
    
    public function newAuthors()
    {
        $newAuthors = User::where('admin','0')
        ->where('active','1')
        ->orderBy('id','DESC')
        ->limit(4)
        ->get();
        
        return AuthorResource::collection($newAuthors);
    }
}
