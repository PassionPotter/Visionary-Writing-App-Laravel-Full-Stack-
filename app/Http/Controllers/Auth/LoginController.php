<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    //use Session;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //echo "testinghhggg"; exit();
       // $prev_url = $_SERVER['HTTP_REFERER'];
       // echo "<pre>kk"; print_r($prev_url); 
        //Session::put('somekey', 'somevalue');
        //$get_url = Session::get('somekey');
        //echo "<br/> <pre>jj"; print_r($get_url); exit();
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        if(isset($request->previous_url)){
            //dd(str_replace('https://visionarywritings.com/','',$request->previous_url));
            return redirect(str_replace('https://visionarywritings.com/','',$request->previous_url));
        }
        
        //return redirect('admin/home');
        
     //echo "testinghhqq"; exit();
       // $prev_url = $_SERVER['HTTP_REFERER'];
       // echo "<pre>kk"; print_r($prev_url); 
        //Session::put('somekey', 'somevalue');
        //$get_url = Session::get('somekey');
        //echo "<br/> <pre>jj"; print_r($get_url); exit();
        if (!$user->verified) {
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }/*else if(!$user->active)
        {
            auth()->logout();
            return back()->with('warning', 'Your account awaits for approval, you will be notified once approved.');
        }*/
        return redirect()->intended($this->redirectPath()); // commented by malithmk
    }
}
