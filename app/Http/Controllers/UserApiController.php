<?php

namespace App\Http\Controllers;

use App\User;
use App\profile;
use App\Http\Resources\UserResource;
use App\Jobs\sendVerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserApiController extends Controller
{
    public function index(Request $request)
    {
        $user = User::findOrFail($request->user()->id); 
        
        return new UserResource($user);
    }
    
    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $newUser = $this->create($request->all());
        event(new Registered($user = $newUser));
        
        try
        {
            dispatch(new sendVerificationEmail($user));
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json([
                "error" => "Couldn't register user."    
            ]);
        }
        return new UserResource($newUser);
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_token' => base64_encode($data['email']),
        ]);

        $profile = profile::create([
            'user_id' => $user->id,
            'avatar' => $data['avatar'],
            'dob' => $data['dob'],
            'about' => $data['about'],
            'gender' => $data['gender']
        ]);
             
        return $user;
    }
    
    /**
     * Get allowed scopes for the user.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getScopes(Request $request)
    {
        $user = User::where('email',$request->email)
                ->first();
                
        if (!$user)
        {
            return response()->json([
                "message" => "There is no user associated with this email"
            ], 404);
        }
        
        if ($user->admin)
        {
            return response()->json([
               "scopes" => "user:edit-own user:edit-any user:delete-any user:activate book:create book:edit-own book:edit-any book:activate book:delete-own book:delete-any chapter:create chapter:edit-any chapter:edit-own chapter:activate chapter:delete-own chapter:delete-any" 
            ]);
        }
        else if ($user->active)
        {
            return response()->json([
               "scopes" => "user:edit-own book:create book:edit-own book:delete-own chapter:create chapter:edit-own chapter:delete-own" 
            ]);
        }
        else
        {
            return response()->json([
               "scopes" => "user:edit-own" 
            ]);
        }
    }
}