<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Smtpemail;
use App\profile;
use App\user;
use Auth; 
use App\Rlink;
use DB;
use Mail;
use App\Mail\contactFormSubmission;

class SmtpemailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//echo "testing"; exit();
      
// Mail::send('welcome', [], function ($message){
//     $message->to('farhan.devronix@gmail.com')->subject('Cloudways - Testing mail');
// });
		$email = new contactFormSubmission('rajeev','rajeev@webplanet.co.in','hello welcome');

// Mail::to($emailAddress)->send(new contactFormSubmission);
		// Mail::to('sharoz.alam.khan@gmail.com')->send($email);
  //       die("SAk");
        $user_profile = profile::where('user_id',Auth::user()->id)->get();

        $user_profile = $user_profile[0];
		$smtpemail = Smtpemail::find(1);
        return view('admin.smtpemail.smtpemail',compact('user_profile','smtpemail'));
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
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

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
            'MAIL_HOST' =>'required',
            'MAIL_PORT' =>'required',
			'MAIL_USERNAME' =>'required',
			'MAIL_PASSWORD' =>'required',
			'MAIL_FROM_ADDRESS' =>'required',
            ]);		
        //$newAd['MAIL_DRIVER'] = $request->MAIL_DRIVER;
        $smtp['MAIL_HOST'] = $request->MAIL_HOST;
        $smtp['MAIL_PORT'] = $request->MAIL_PORT;
        $smtp['MAIL_USERNAME'] = $request->MAIL_USERNAME;
		$smtp['MAIL_PASSWORD'] = $request->MAIL_PASSWORD;
		$smtp['MAIL_FROM_ADDRESS'] = $request->MAIL_FROM_ADDRESS;				
		$update = Smtpemail::find(1);
        $update->update($smtp);
        Session::flash('success','Smtp email updated successfuly');		
		return redirect()->back();
    }

    public function sendmail()
    {
        return view('admin.smtpemail.sendmail');
    }

    public function send_mail(Request $req)
    {   
        $this->validate($req, [
            'subject_mail' => 'required',
            'message_mail' => 'required'
            ]);
         
        $reader = $req->reader_mail;            
        $subject2 = $req->subject_mail;
        $message = $req->message_mail;
        $users = User::select("name","email","reader")
                    ->where('active','1')
               //  ->where('email','aliwajid5522@gmail.com')
                    ->whereIn('reader', $reader)
                    ->get();      
         
        foreach ($users as $user) {                
                
            $user_name = $user->name;
            $user_email = $user->email;
           
            $data = array('name'=>'', 'body' => $message);
		
 	//echo "<pre>hhgg"; print_r($data); echo "<br/>"; 
		//echo "<pre>hhgg"; print_r($message); echo "<br/>"; 
		//echo "<pre>hhgg"; print_r($user_name); echo "<br/>"; 
		//echo "<pre>hhgg"; print_r($user_email); echo "<br/>";
		//echo "<pre>hhgg"; print_r($user_email,$subject2); echo "<br/>";
		//echo "<pre>hhgg"; print_r(Mail::send('admin.email.mail', $data, function($message) use ($user_name, $user_email,$subject2) {

                 //   $message->to($user_email, $user_name)
                //            ->subject($subject2);
                   // $message->from('admin@visionarywritings.com','Test Mail');
            //})); echo "<br/>";
		
		//exit();
		
            Mail::send('admin.email.mail', $data, function($message) use ($user_name, $user_email,$subject2) {

                    $message->to($user_email, $user_name)
                            ->subject($subject2);
                   // $message->from('admin@visionarywritings.com','Test Mail');
            });
        }  
        Session::flash('success','Successfully send in your mail');
        return redirect()->back();
    }
}


























