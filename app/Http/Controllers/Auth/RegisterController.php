<?php
namespace App\Http\Controllers\Auth;
use App\User;
use App\profile;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Jobs\sendVerificationEmail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;


// require DIR . '/twilio-php-master/src/Twilio/autoload.php';
require "vendor/autoload.php"; 

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
      //  echo "testinghhqqwwasdad"; exit();
        $this->middleware('guest');
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
            'phone' => 'required|numeric|min:6',
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
      // echo "ttt"; exit();
 
        // old data open

       

      
        // return $user;
         //    $digits = 5;
         //    $number_code =  rand(pow(10, $digits-1), pow(10, $digits)-1);
         //    $data["number_code"] = $number_code;
         //    /* Get credentials from .env */
         // // $token = getenv("AC219db4917f6c3ed46b716df1b6a280af");
         // // $twilio_sid = getenv("6609e099e7e141cc8b6b1f8d8b141462");
         // //    $twilio_verify_sid = getenv("VA7476c3f26c65804b67efa33af15bbd30");
         //    // print_r($data['phone']);
         //    // echo "<br>";
         //    if (substr($data['phone'], 0, 3) == '+27') {
             
             
         //    // echo substr($data['phone'], 0, 3); 
         //    // die("sak");
         //      $messageTEMP = "This is a five digit verification code from Visionary Writings Code:".$number_code;
         //      $sid = "AC4b9f855f31fa4e27384e206a7a89e940";
         //      $token = "f9519c991c2a9a50bf6e9058e541dba4";
         //      $client = new Client($sid, $token);
         //      $message = $client->messages->create(
         //          $data['phone'], // Text this number
         //          [
         //         'from' => '+27600702391', // From a valid Twilio number
         //         'body' => $messageTEMP
         //       ]
         //     ); 
         //    }
      //       $sid = "SK683c2c3c50af8e693ef443ac130f7d94";
      //        $token = "f9519c991c2a9a50bf6e9058e541dba4";
      //       $client = new Client($sid, $token);
      //       $messageTEMP = "This is a five digit verification code from Vsionary Writting Code:".$number_code;
      //       $message = $client->messages->create(
      //     '+27600702391', // Text this number
      //    [
      //    'from' => '+27600702391', // From a valid Twilio number
      //    'body' => $messageTEMP,
      // ]
      // );
            // if ($message->sid != "") {
            //   $checker = 0;
            // } else {
            //   $checker = 1;
            // }
             $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            // 'number_code' => $data["number_code"],
            // 'phone_verified' => $checker,
            'phone_verified' => 1,
            'password' => Hash::make($data['password']),
            'email_token' => base64_encode($data['email']),
        ]);

            $profile=profile::create([
            'user_id' => $user->id,
            'avatar' => $data['avatar'],
            'dob' => $data['dob'],
            'about' => $data['about'],
            'gender' => $data['gender']
        ]);
      //       print $message->sid;

      //       die('far');
        
        // $user=  User::create([
        //      'name' => $data['name'],
        //      'phone' => $data['phone'],
        //      'reader' => 1,
        //      'password' => Hash::make($data['password']),
        //      'email' => $data['email'],
        //      'email_token' => base64_encode($data['email']),
        //  ]);


        // $profile=profile::create([
        //     'user_id' => $user->id,
        //     'avatar' => $data['avatar'],
        //     'dob' => $data['dob'],
        //     'about' => $data['about'],
        //     'gender' => $data['gender']
        // ]);
        // redirect()->route('verify')->with(['phone' => $data['phone']]);
        return $user; 
       
    }
    //  protected function create_reader(array $data)
    // {
      
    //     $user = User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'reader' => 1,
    //         'active' => 1,
    //         'password' => Hash::make($data['password']),
    //         'email_token' => base64_encode($data['email']),
    //     ]);
        
    //     $profile=profile::create([
    //         'user_id' => $user->id,
    //         'avatar' => $data['avatar'],
    //         'dob' => $data['dob'],
    //         'about' => $data['about'],
    //         'gender' => $data['gender']
    //     ]);

    //     return $user;
    // }

    /**
    * Handle a registration request for the application.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
     // echo "gggkk"; exit();
        $this->validator($request->all())->validate();
        $data = $request->all();
        event(new Registered($user = $this->create($request->all())));
        // event(new Registered($user = $this->create_reader($request->all())));
        try
        {
          
        dispatch(new sendVerificationEmail($user));
        }
        catch(ModelNotFoundException $e)
        {
        echo "We are experiecing technical issues at the moment, please try again later";
        }
        //return view('email.verification');
        return view('email.verification',['user'=>$user]);
    }
    
     public function resendEmailRegister($email = "")
    {
        
        $user   =   DB::table("users")->where("email",$email)->select("users.*")->first();
         dispatch(new sendVerificationEmail($user));
        
        //return view('email.verification');
      return view('email.verification',['email'=>$email]);
    }
    
    /**
    * Handle a registration request for the application.
    *
    * @param $token
    * @return \Illuminate\Http\Response
    */
    public function verify($token)
    {
        $user = User::where('email_token',$token)->first();
        $user->verified = 1;
        if($user->save()){
            return view('email.emailconfirm',['user'=>$user]);
        }
    }

}
