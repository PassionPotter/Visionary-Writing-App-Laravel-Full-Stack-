<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use Image;
use Session;
class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.users.profile')->with('user',Auth::user());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'name' =>'required',
            'email' =>'required|email'
            ]);
      
        $user =Auth::user();

        if($request->hasFile('avatar')){
            $image=$request->avatar;
            $avatar=time().'_'.str_random(6).'.'.strtolower($image->getClientOriginalExtension()); 
            Image::make($image)->save(public_path('books/avatars/').$avatar);
            $user->profile->avatar=$avatar;
            $user->profile->save();
        }
        if($request->has('dob')){
            $user->profile->dob=$request->dob;
            $user->profile->save();

        }
        if($request->has('gender')){
            $user->profile->gender=$request->gender;
            $user->profile->save();
        }

        $user->name=$request->name;
        $user->email=$request->email;
       // $user->password=Hash::make($request->password);
        $user->profile->about =$request->about;
        $user->save();
        $user->profile->save();

        if($request->has('password') && !empty($request->password))
        {
            //$user->password = bcrypt($request->password);
             $user->password=Hash::make($request->password);
            $user->save();
        }

        Session::flash('success','profile updated successfuly');
        return redirect()->back();
         

    }
    public function updateImage(Request $request)
    {
       
       print_r($request);exit;
        /*$user =Auth::user();

        if($request->has('image')){
              $imgg = $request->image;
            $immgg =  explode("base64,",$imgg);
        
            $img = str_replace(' ', '+', $immgg[1]);
            $data = base64_decode($img);
            $avatar=time().'_'.str_random(6). '.png';
            $file = public_path('books/avatars/') . $avatar;

            $success = file_put_contents($file, $data);
             
            $user->profile->avatar=$avatar;
            $user->profile->save();
             print_r($avatar);
            print_r($user->profile->save());exit;
        }*/
        

        //Session::flash('success','profile updated successfuly');
        //return redirect()->back();
        
         

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
