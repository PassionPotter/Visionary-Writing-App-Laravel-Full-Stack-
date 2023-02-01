<?php 


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
class AjaxController extends Controller
{
	public function updateCustomerRecord(Request $request)
    {
        // do something here
        $data = $request->all(); // This will get all the request data.

        //dd(Auth::user()); // This will dump and die
        $user =Auth::user();
         //print_r($request->has('image'));exit;
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
        }
    }
    /*updateCustomerRecordUser*/
    public function updateCustomerRecordUser(Request $request)
    {
        // do something here
        $data = $request->all(); // This will get all the request data.
        $user = User::find($request->user_id);
        //echo'<pre>';
        //print_r($user); die;

        if($request->has('image')){
              $imgg = $request->image;
            $immgg =  explode("base64,",$imgg);
        
            $img = str_replace(' ', '+', $immgg[1]);
            $data = base64_decode($img);
            $avatar=time().'_'.str_random(6). '.png';
            $file = public_path('books/avatars/') . $avatar;
            //echo $data.'here';
            $success = file_put_contents($file, $data);
             
            $user->profile->avatar = $avatar;
            $user->profile->save();


            return response()->json(['avatar' => $avatar]);
            print_r($avatar);
            exit;
        }
    }
}

 ?>