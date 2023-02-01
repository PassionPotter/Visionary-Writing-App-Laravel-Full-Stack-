<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chapter;
use App\User;
use App\Book;
use App\Bankdetail;
use App\ad;
use App\profile;
use Excel;
use Auth;
use Session;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Jobs\sendContactFormToAdmin;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Hash;
use App\Jobs\sendVerificationEmail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function testmail(){
       // return $user;
            $digits = 5;
            $number_code =  rand(pow(10, $digits-1), pow(10, $digits)-1);
            $data["number_code"] = $number_code;

            
            /* Get credentials from .env */
         // $token = getenv("AC219db4917f6c3ed46b716df1b6a280af");
         // $twilio_sid = getenv("6609e099e7e141cc8b6b1f8d8b141462");
         //    $twilio_verify_sid = getenv("VA7476c3f26c65804b67efa33af15bbd30");
            $messageTEMP = "This is a five digit verification code from Vsionary Writting Code:".$number_code;
            $sid = "AC4b9f855f31fa4e27384e206a7a89e940";
             $token = "f9519c991c2a9a50bf6e9058e541dba4";
            $client = new Client($sid, $token);
            $message = $client->messages->create(
          '+27621429116', // Text this number
         [
         'from' => '+27600702391', // From a valid Twilio number
         'body' => $messageTEMP
      ]
      );
      print $message->sid;
      // $to_name = 'Sharoz';
      // $to_email = 'shahrooz.devronix@gmail.com';
      // $data = array('name'=>'Ogbonna Vitalis(sender_name)', 'body' => 'A test mail');
      // Mail::send('email.mail', $data, function($message) use ($to_name, $to_email) {
      //   $message->to($to_email, $to_name)
      //   ->subject('Laravel Test Mail');
      //   $message->from('admin@visionarywritings.com','Test Mail');
      // });
    }
    
    public function paginate($items, $perPage = 18, $page = null, $options = [])
    {
      $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
      $items = $items instanceof Collection ? $items : Collection::make($items);
      return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }   
    public function index()
    {


//echo "testinghh"; exit();
     //  $from = date('2019-04-07' . ' 00:00:00', time()); //need a space after dates.
     //  $to = date('2020-04-01' . ' 00:00:00', time());

     //  $all_books = Book::where('status', '1')->whereHas('user', function($q){
     //    $q->where('verified', 1);
     //    $q->where('active', 1);
     //  })
     //  ->has('Chapters', '>=', 20)

     // ->whereBetween('created_at', array($from, $to))->get();  
     //     // ->paginate('10');
     //  echo "<pre>";
     //  print_r($all_books);
     //  die('far');





      // $users = DB::table('users')
      // ->select('users.id','users.name','profiles.avatar')
      // ->leftjoin('profiles', 'users.id', '=', 'users.id')

      // ->where('users.active',1)
      // ->paginate(15);




        // $users = User::where('admin','0')
        // ->where('active','1')
        // ->orderby('name','ASC')
        // ->paginate(24);
        // print_r($total_projects);die;

      if (isset($_GET["page"])) {  
        $pn  = $_GET["page"];  
      } else {  
        $pn=1;  
      };
      $limit = 21;
      $start_from = ($pn-1) * $limit;
      $users =  DB::select(DB::raw("SELECT users.id, users.name, cd.title, cd.updated_at, profiles.avatar FROM `users` LEFT JOIN ( SELECT MAX(id) max_id, user_id FROM book GROUP BY user_id ) c_max ON (c_max.user_id = users.id) LEFT JOIN book cd ON (cd.id = c_max.user_id) JOIN profiles ON (profiles.user_id = users.id  AND users.active='1' AND users.admin='0') ORDER by cd.updated_at DESC limit $start_from, $limit"));

        /* ->paginate('10');
     
        Logic for Chapter updated
        SELECT users.id, users.name, cd.title, chd.title chapterTitle, chd.updated_at chapter_updated, cd.updated_at, profiles.avatar FROM `users` LEFT JOIN ( SELECT MAX(id) max_id, user_id FROM book GROUP BY user_id ) c_max ON (c_max.user_id = users.id) LEFT JOIN book cd ON (cd.id = c_max.user_id) JOIN profiles ON (profiles.user_id = users.id AND users.active='1' AND users.admin='0') LEFT JOIN ( SELECT MAX(id) max_cid, book_id FROM Chapter GROUP BY book_id ) ch_max ON (ch_max.book_id = cd.id) LEFT JOIN Chapter chd ON (chd.id = ch_max.max_cid) ORDER BY `chapter_updated` DESC
        */
        
        $newAuthors = User::where('admin','0')
        ->where('active','1')
        ->where('reader','0')
        ->orderBy('approved_at','DESC')
        ->limit(10)
        ->get();


        $newRelease = Book::select('book.id as id', 'book.title', 'book.slug', 'book.book_cover',  'book.user_id', 'users.name','users.verified', 'users.active',DB::raw('COUNT(Chapter.id) as total_chapter'))
         
        ->where('book.complete','1')
         
        ->join('users', 'users.id', '=', 'book.user_id')
        ->join('Chapter', 'Chapter.book_id', '=', 'book.id')
        ->WHERE ('users.verified', '1')
        ->WHERE ('users.active', '1')    
        ->having('total_chapter','>=','20')
        ->orderBy('book.updated_at','DESC')
        ->groupBy('book.id')
        ->limit(15)
        ->get();

        // new query custom far
        $recent_users = DB::select(DB::raw("SELECT profiles.avatar,book.user_id,users.admin, name, COUNT(Chapter.book_id) AS 'value_occurrence' FROM book INNER JOIN Chapter ON book.id = Chapter.book_id INNER JOIN users ON book.user_id = users.id LEFT JOIN profiles ON profiles.id = users.id WHERE Chapter.created_at >= (CURDATE() - INTERVAL 7 DAY) AND users.active = 1 GROUP BY book.user_id ORDER BY value_occurrence DESC"));
        $recent_users_ids='';
        foreach ($recent_users as $key => $value) {
          $recent_users_ids .= "'".$value->user_id."',";
        }
        $recent_users_ids = rtrim($recent_users_ids, ",");

        // echo "<pre>";
        // print_r($newAuthors);
        // $recent_users = $this->paginate($recent_users);

        // echo "<BR>asdascuasvuigiuvuisdvhauivhvuidhavsd";
        // print_r($recent_users);
        
        if($recent_users_ids){
          $users =  DB::select(DB::raw("SELECT profiles.avatar,book.user_id,users.admin, name,
          COUNT(Chapter.book_id) AS 'value_occurrence'
          FROM book
          INNER JOIN Chapter ON book.id = Chapter.book_id 
          INNER JOIN users ON book.user_id = users.id
          LEFT JOIN profiles
          ON profiles.id = users.id
          WHERE users.active = 1
          AND users.id NOT IN ($recent_users_ids)
          GROUP BY book.user_id
          ORDER BY value_occurrence DESC"));
        }else{
          $users =  DB::select(DB::raw("SELECT profiles.avatar,book.user_id,users.admin, name,
          COUNT(Chapter.book_id) AS 'value_occurrence'
          FROM book
          INNER JOIN Chapter ON book.id = Chapter.book_id 
          INNER JOIN users ON book.user_id = users.id
          LEFT JOIN profiles
          ON profiles.id = users.id
          WHERE users.active = 1
          GROUP BY book.user_id
          ORDER BY value_occurrence DESC"));
        }
        // $users =  DB::select(DB::raw("SELECT profiles.avatar,book.user_id,users.admin, name,
        //   COUNT(Chapter.book_id) AS 'value_occurrence'
        //   FROM book
        //   INNER JOIN Chapter ON book.id = Chapter.book_id 
        //   INNER JOIN users ON book.user_id = users.id
        //   LEFT JOIN profiles
        //   ON profiles.id = users.id
        //   WHERE users.active = 1
        //   GROUP BY book.user_id
        //   ORDER BY value_occurrence DESC"));
                                  // 

                                  // $users = $recent_users->merge($users);

        $users =array_merge($recent_users,$users);

        $users = $this->paginate($users);
                                  // echo "<pre>";
                                  // print_r($users);
                                  // die("sak");
       // SELECT profiles.avatar,book.user_id, name,
       //    COUNT(book.user_id) AS 'value_occurrence'
       //    FROM book
       //    INNER JOIN users ON book.user_id = users.id
       //    LEFT JOIN profiles
       //    ON profiles.id = users.id
       //    WHERE users.active = 1
       //    GROUP BY book.user_id
       //    ORDER BY value_occurrence DESC

        // $tFH_users = DB::table('users')->where('verified', '=',0)->where('created_at', '<=', Carbon::now()->subDay())->count(); //1737
        // echo "<pre>";
        // echo Carbon::now()->subDay();
        // print_r($tFH_users);
        // die("saj");
    //dd($newRelease);
   // dd(DB::getQueryLog());    
        //echo "<pre>";print_r($users);exit;

        return view('frontend/index',compact('users', 'newAuthors', 'newRelease','recent_users'));
      }
      public function whoyouare()
      {
        return view('auth/select-reg-type');
      }
      public function regAsReader()
      {
        return view('auth/readerForm');
      }
      public function dummy()
      {
        $users = User::where('admin','0')
        ->where('active','1')
        ->orderBy('name','ASC')
        ->paginate(24);

        $newAuthors = User::where('admin','0')
        ->where('active','1')
        ->orderBy('id','DESC')
        ->limit(4)
        ->get();

        //print_r($newAuthors);exit;

        $newRelease = Book::select('book.id as id', 'book.title','book.slug','book.book_cover',  'book.user_id', 'users.name','users.verified')
        ->where('book.status','1')
        ->where('users.verified','1')
        ->where('users.active','1')
        ->join('users', 'users.id', '=', 'book.user_id')
        ->orderBy('book.id','DESC')
        ->limit(15)
        ->get();
        //print_r($newRelease);exit;

        return view('frontend/dummy',compact('users', 'newAuthors', 'newRelease'));
      }

      public function display_allauthors(Request $request)
      {
        $users = User::where('active','1')->where('reader',0)->where('admin',0)->orderBy('approved_at','desc')->limit(10)->get();
        return view('frontend/allauthors',compact('users'));

      }
      public function display_allbooks(Request $request)
      {   
         // echo "ff"; exit();

        $all_books = Book::where('complete', '1')->whereHas('user', function($q){
          $q->where('verified', 1);
          $q->where('active', 1);
        })
        ->has('Chapters', '>=', 20)
        
        ->orderBy('book.updated_at','DESC')
        ->groupBy('book.id')    
        ->paginate('10');
          
//->orderby('book.created_at','DESC')
          //->orderBy('book.id','DESC')
      // old query comment far
      // $all_books = Book::select('book.*','book.id as book_id', 'users.*','users.id as user_id')
      //   ->where('book.status','1')
      //   ->where('users.verified','1')
      //   ->where('users.active','1')
      //   ->where('users.active','1')
      //   // ->whereSum('Chapter.id', '>' , 20)
      //   ->join('users', 'users.id', '=', 'book.user_id')
      //   // ->join('Chapter', 'book_id', '=', 'book.id')
      //   ->orderBy('book.created_at','DESC')
      //   ->paginate(10);



      //$all_books = Book::select()->paginate(10);

        foreach ($all_books as $key => $value) {

         $value['view_count'] = $this->number_format_short(DB::table('books_view_count')->where('book_id',$value['id'])->count());
       }

       $sidebarAds=ad::where('type', 'sidebar')->where('page','Books')->where('status','1')->get();
       $bottomAd=ad::where('type', 'Bottom')->where('page','Books')->where('status','1')->get();
       $topAd=ad::where('type', 'Top')->where('page','Books')->where('status','1')->get();
       $afterTwoBooks=ad::where('type', 'afterTwoBooks')->where('page','Books')->where('status','1')->get()->toArray();

       $rlinks = DB::table('rlinks')->where('status',1)->orderByRaw('id DESC')->get();
       $rkeywords = DB::table('rkeywords')->where('status',1)->orderByRaw('id DESC')->get();


       return view('frontend/allbooks',compact('all_books','sidebarAds','bottomAd','topAd','afterTwoBooks', 'rlinks','rkeywords'));

     }








     public function about()
     {
      return view('frontend/about');
    }
    public function faq()
    {
      return view('frontend/faq');
    }
    public function submitForm(Request $request)
    {
      //echo $request->input('secret');
      //echo $request->input('response');
      //echo $request->ip();exit;

      $rules = [
        'name'=> 'required',
        'email' => 'required|email',
        'Message'=> 'required',
        'g-recaptcha-response'=>'required',
            //'g-recaptcha-response'=>'required|recaptcha',
      ];

      $customMessages = [
       'name.required' => 'Please provide your name',
       'email.required' => 'Please provide a valide email',
       'email.email' => 'Please provide a valide email',
       'Message.required' => 'Please provide purpose of this message',
       'g-recaptcha-response.required' => 'Please provide a reCAPTCHA',
             //'g-recaptcha-response.recaptcha' => 'Please ensure that you are a human!',
     ];

     $this->validate($request, $rules, $customMessages);
     dispatch(new sendContactFormToAdmin($request->name,$request->email,$request->Message));
     return view('frontend/contact')->withSuccess('Thanks, your message has been received');
   }

   public function contact()
   {
    return view('frontend/contact');
  }

  public function tnpp()
  {
    return view('frontend/tnpp');
  }

  public function register()
  {

    return view('frontend/register');
  }
  public function registerReader(Request $request)
  {
    $this->validate($request, [

      'name' => 'required|string|max:255',
      'username' => 'required|string|max:255|unique:users',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6|confirmed',
     // 'g-recaptcha-response' => 'required|captcha',

    ]);
    $data = $request->all();
   
    $data['password'] = Hash::make($data['password']);
    $data['email_token'] = base64_encode($data['email']);
    //$data['verified'] = 1;
    $data['active'] = 1;
    $data['approved_at'] = date("Y-m-d");

    $user = User::create($data);
    
    $profile=profile::create([
            'user_id' => $user->id,
            'avatar' => $data['avatar']        
          ]);
    $user   =   DB::table("users")->where("email",$data['email'])->select("users.*")->first();
         dispatch(new sendVerificationEmail($user));
        
        //return view('email.verification');
    view('email.verification',['email'=>$data['email']]);

    return view('email.reader_verification',['email'=>$data['email']]);
    // return redirect('login');
  }

  public function resendCode($email)
  {
    $data = User::where('email',$email)->get();
    print_r($data);
    die("Sak");
    $digits = 5;
    $number_code =  rand(pow(10, $digits-1), pow(10, $digits)-1);
    $data["number_code"] = $number_code;
    $messageTEMP = "This is a five digit verification code from Visionary Writting Code:".$number_code;
    $sid = "AC4b9f855f31fa4e27384e206a7a89e940";
    $token = "f9519c991c2a9a50bf6e9058e541dba4";
    $client = new Client($sid, $token);
    $message = $client->messages->create(
          '+27621429116', // Text this number
          [
         'from' => '+27600702391', // From a valid Twilio number
         'body' => $messageTEMP
       ]
     ); 
  }
  public function display_authors_books(Request $request, $author, $id)
  {   
    return redirect()->route('author/author_id',$id);


    //print_r(session()->getId());exit;
    if (Auth::check()) {

      $loginuserid = Auth::user()->id;

      $chkuser = DB::table('authors_view_count')
      ->where('user_id', $id)
      ->where('logged_in_user_id', $loginuserid)
      ->count();

      if($chkuser == 0){

        if(preg_match('/^\d+$/',$id)){
          DB::table('authors_view_count')->insert(array('session_id' => session()->getId(), 'user_id' => $id, 'logged_in_user_id' => $loginuserid));
            DB::table('users')
                ->where('id', $id)
                ->increment('views', 1);
        }else{
          return abort(404);
        }


        $authors_count = DB::table('authors_view_count')->where('user_id',$id)->count();
        $authors_view_count = $authors_count;

        $amt = 0.01;
        $type = 'profile';

        $created_at = date("Y-m-d");

        DB::table('transaction')
        ->insert(array(
          'user_id' => $id, 
          'amount' => $amt, 
          'type' => $type,
          'on_views' => $authors_view_count,
          'date' => $created_at));

        DB::table('users')
        ->where('id', $id)
        ->increment('amount', $amt);

        DB::table('users')
        ->where('admin', 1)
        ->increment('amount', $amt);
      }
      
      
    }else{

      $authors_count = DB::table('authors_view_count')->where('session_id',session()->getId())->where('user_id',$id)->count();

      if($authors_count == 0){  
        if(preg_match('/^\d+$/',$id)){

          DB::table('authors_view_count')->insert(array('session_id' => session()->getId(), 'user_id' => $id));
            DB::table('users')
                ->where('id', $id)
                ->increment('views', 1);
        } else {
          return abort(404);
        }

        $authors_count = DB::table('authors_view_count')->where('user_id',$id)->count();
        $authors_view_count = $authors_count;

        $amt = 0.01;
        $type = 'profile';

        $created_at = date("Y-m-d");

        DB::table('transaction')
        ->insert(array(
          'user_id' => $id, 
          'amount' => $amt, 
          'type' => $type,
          'on_views' => $authors_view_count,
          'date' => $created_at));

        DB::table('users')
        ->where('id', $id)
        ->increment('amount', $amt);

        DB::table('users')
        ->where('admin', 1)
        ->increment('amount', $amt);
        
      }
    }



    $authors_count = DB::table('authors_view_count')->where('user_id',$id)->count();
    $authors_view_count = $authors_count;
    //      $authors_view_count = count($authors_count);
      //echo $authors_view_count;exit;
    $authors_view_count = $this->number_format_short($authors_view_count);


    $author = User::find($id);
    $author_books = Book::select('id','book_cover','title','slug','book_order', 'genre')->where('user_id', $id)->where('status', '1')
    ->where('deleted_at', null)->orderBy('book_order', 'ASC')->paginate(10);
      // $author_books = User::find($id)->books()->orderBy('created_at', 'ASC')->paginate(10);
    foreach ($author_books as $key => $value) {
     $value['view_count'] = $this->number_format_short(DB::table('books_view_count')->where('book_id',$value['id'])->count());
         //$value['view_count'] = count(DB::table('books_view_count')->where('book_id',$value['id'])->get());
   }

   $sidebarAds=ad::where('type', 'sidebar')->where('page','Books')->where('status','1')->get();
   $bottomAd=ad::where('type', 'Bottom')->where('page','Books')->where('status','1')->get();
   $topAd=ad::where('type', 'Top')->where('page','Books')->where('status','1')->get();
   $afterTwoBooks=ad::where('type', 'afterTwoBooks')->where('page','Books')->where('status','1')->get()->toArray();

   $rlinks = DB::table('rlinks')->where('status',1)->orderByRaw('id DESC')->get();
   $rkeywords = DB::table('rkeywords')->where('status',1)->orderByRaw('id DESC')->get();


   return view('frontend/books',compact('author','author_books','sidebarAds','bottomAd','topAd','afterTwoBooks','authors_view_count','rlinks','rkeywords'));

 }
 public function display_authorss_books($id)
 {   



    //print_r(session()->getId());exit;
  if (Auth::check()) {

    $loginuserid = Auth::user()->id;

    $chkuser = DB::table('authors_view_count')
    ->where('user_id', $id)
    ->where('logged_in_user_id', $loginuserid)
    ->count();

    if($chkuser == 0){

      if(preg_match('/^\d+$/',$id)){
        DB::table('authors_view_count')->insert(array('session_id' => session()->getId(), 'user_id' => $id, 'logged_in_user_id' => $loginuserid));
          DB::table('users')
              ->where('id', $id)
              ->increment('views', 1);
      }else{
        return abort(404);
      }


      $authors_count = DB::table('authors_view_count')->where('user_id',$id)->count();
      $authors_view_count = $authors_count;

      $amt = 0.01;
      $type = 'profile';

      $created_at = date("Y-m-d");

      DB::table('transaction')
      ->insert(array(
        'user_id' => $id, 
        'amount' => $amt, 
        'type' => $type,
        'on_views' => $authors_view_count,
        'date' => $created_at));

      DB::table('users')
      ->where('id', $id)
      ->increment('amount', $amt);

      DB::table('users')
      ->where('admin', 1)
      ->increment('amount', $amt);
    }


  }else{

    $authors_count = DB::table('authors_view_count')->where('session_id',session()->getId())->where('user_id',$id)->count();

    if($authors_count == 0){  
      if(preg_match('/^\d+$/',$id)){

        DB::table('authors_view_count')->insert(array('session_id' => session()->getId(), 'user_id' => $id));
          DB::table('users')
              ->where('id', $id)
              ->increment('views', 1);
      } else {
        return abort(404);
      }

      $authors_count = DB::table('authors_view_count')->where('user_id',$id)->count();
      $authors_view_count = $authors_count;

      $amt = 0.01;
      $type = 'profile';

      $created_at = date("Y-m-d");

      DB::table('transaction')
      ->insert(array(
        'user_id' => $id, 
        'amount' => $amt, 
        'type' => $type,
        'on_views' => $authors_view_count,
        'date' => $created_at));

      DB::table('users')
      ->where('id', $id)
      ->increment('amount', $amt);

      DB::table('users')
      ->where('admin', 1)
      ->increment('amount', $amt);

    }
  }



  $authors_count = DB::table('authors_view_count')->where('user_id',$id)->count();
  $authors_view_count = $authors_count;
    //      $authors_view_count = count($authors_count);
      //echo $authors_view_count;exit;
  $authors_view_count = $this->number_format_short($authors_view_count);


  $author = User::find($id);
  $author_books = Book::select('id','book_cover','title','complete','slug','book_order', 'genre')->where('user_id', $id)->where('status', '1')
  ->where('deleted_at', null)->orderBy('book_order', 'ASC')->paginate(10);
      // $author_books = User::find($id)->books()->orderBy('created_at', 'ASC')->paginate(10);
  foreach ($author_books as $key => $value) {
   $value['view_count'] = $this->number_format_short(DB::table('books_view_count')->where('book_id',$value['id'])->count());
         //$value['view_count'] = count(DB::table('books_view_count')->where('book_id',$value['id'])->get());
 }

 $sidebarAds=ad::where('type', 'sidebar')->where('page','Books')->where('status','1')->get();
 $bottomAd=ad::where('type', 'Bottom')->where('page','Books')->where('status','1')->get();
 $topAd=ad::where('type', 'Top')->where('page','Books')->where('status','1')->get();
 $afterTwoBooks=ad::where('type', 'afterTwoBooks')->where('page','Books')->where('status','1')->get()->toArray();

 $rlinks = DB::table('rlinks')->where('status',1)->orderByRaw('id DESC')->get();
 $rkeywords = DB::table('rkeywords')->where('status',1)->orderByRaw('id DESC')->get();


 return view('frontend/books',compact('author','author_books','sidebarAds','bottomAd','topAd','afterTwoBooks','authors_view_count','rlinks','rkeywords'));

}

public function displayBookByGenre($genre){
  // echo $genre;
  // die(":Saj");
    // if (empty($genre)) {
    //  $genre = "all";
    // }
  $all_books = Book::where('status', '1')->whereHas('user', function($q){
    $q->where('verified', 1);
    $q->where('active', 1);
  })
  ->has('Chapters', '>=', 20)
  ->where('genre','=',$genre)
  ->orderby('book.created_at','DESC')
  ->paginate('10');

  foreach ($all_books as $key => $value) {

   $value['view_count'] = $this->number_format_short(DB::table('books_view_count')->where('book_id',$value['id'])->count());
 }

 $sidebarAds=ad::where('type', 'sidebar')->where('page','Books')->where('status','1')->get();
 $bottomAd=ad::where('type', 'Bottom')->where('page','Books')->where('status','1')->get();
 $topAd=ad::where('type', 'Top')->where('page','Books')->where('status','1')->get();
 $afterTwoBooks=ad::where('type', 'afterTwoBooks')->where('page','Books')->where('status','1')->get()->toArray();

 $rlinks = DB::table('rlinks')->where('status',1)->orderByRaw('id DESC')->get();
 $rkeywords = DB::table('rkeywords')->where('status',1)->orderByRaw('id DESC')->get();


 return view('frontend/allbooks',compact('all_books','sidebarAds','bottomAd','topAd','afterTwoBooks', 'rlinks','rkeywords'));
}
public function display_book_chapters(Request $request, $author,$auhthorId, $book, $id)
{
  return redirect()->route('author/book_id',[$auhthorId,$id]);
  try{
    $author = User::findOrFail($auhthorId);
  }
  catch(ModelNotFoundException $e)
  {
    dd($e);
  }


  if (Auth::check()) {

    $loginuserid = Auth::user()->id;

    $chkuser = DB::table('books_view_count')
    ->where('book_id', $id)
    ->where('logged_in_user_id', $loginuserid)
    ->count();

    if($chkuser == 0){
     if(preg_match('/^\d+$/',$id)){

      DB::table('books_view_count')->insert(array('session_id' => session()->getId(), 'book_id' => $id, 'logged_in_user_id' => $loginuserid));
         DB::table('book')
             ->where('id', $id)
             ->increment('views', 1);
    }
    else
    {
      return abort(404);
    }

    $book_view_count = DB::table('books_view_count')->where('book_id', $id)->count();

    $amt = 0.002;
    $type = 'book';

    $created_at = date("Y-m-d");

    DB::table('transaction')
    ->insert(array(
      'user_id' => $auhthorId, 
      'amount' => $amt, 
      'type' => $type,
      'on_views' => $book_view_count,
      'date' => $created_at));

    DB::table('users')
    ->where('id', $auhthorId)
    ->increment('amount', $amt);

    DB::table('users')
    ->where('admin', 1)
    ->increment('amount', $amt);
  }


}else{

  $book_view_count = DB::table('books_view_count')->where('session_id',session()->getId())->where('book_id',$id)->count();

  if($book_view_count == 0)
  {
    if(preg_match('/^\d+$/',$id)) {
     DB::table('books_view_count')->insert(array('session_id' => session()->getId(), 'book_id' => $id));
        DB::table('book')
            ->where('id', $id)
            ->increment('views', 1);
   } else
   {
    return abort(404);
  }

  $book_view_count = DB::table('books_view_count')->where('book_id',$id)->count();

        //$amt = floor($book_view_count/1000) * 2;
  $amt = 0.002;
  $type = 'book';

  $created_at = date("Y-m-d");

  DB::table('transaction')
  ->insert(array(
    'user_id' => $auhthorId, 
    'amount' => $amt, 
    'type' => $type,
    'on_views' => $book_view_count,
    'date' => $created_at));

  DB::table('users')
  ->where('id', $auhthorId)
  ->increment('amount', $amt);

  DB::table('users')
  ->where('admin', 1)
  ->increment('amount', $amt);

}

}

$book_view_count = DB::table('books_view_count')->where('book_id',$id)->count();
$authors_view_count = $this->number_format_short($book_view_count);

$chapters = Book::findorFail($id)->Chapters()->orderBy('created_at','asc');
$book = Book::find($id);
$bottomAd=ad::where('type', 'Bottom')->where('page','Chapters')->where('status','1')->get();
$topAd=ad::where('type', 'Top')->where('page','Chapters')->where('status','1')->get();

$restrictedlinks = DB::table('rlinks')->where('status',1)->orderByRaw('id DESC')->get();
$restrictedKeywords = DB::table('rkeywords')->where('status',1)->orderByRaw('id DESC')->get();
$afterTwoChapters = ad::where('type', 'aftertwochapters')->where('page','Chapters')->where('status','1')->get()->toArray();

return view('frontend/chapters')
->with('author',$author)
->with('chapters',$chapters->paginate(10))
->with('book',$book)
->with('bottomAd',$bottomAd)
->with('topAd',$topAd)
->with('restrictedlinks',$restrictedlinks)
->with('restrictedKeywords',$restrictedKeywords)
->with('afterTwoChapters',$afterTwoChapters)
->with('book_view_count',$book_view_count);
}
public function display_books_chapters(Request $request,$auhthorId, $id)
{ 
  // echo "testing"; print_r($id); exit();
  try{
    $author = User::findOrFail($auhthorId);
  //  echo "<pre>"; echo "testing3========"; print_r($author); exit();
  }
  catch(ModelNotFoundException $e)
  {
    dd($e);
  }

  
  if (Auth::check()) {

    $loginuserid = Auth::user()->id;

    $chkuser = DB::table('books_view_count')
    ->where('book_id', $id)
    ->where('logged_in_user_id', $loginuserid)
    ->count();

    if($chkuser == 0){
     if(preg_match('/^\d+$/',$id)){

      DB::table('books_view_count')->insert(array('session_id' => session()->getId(), 'book_id' => $id, 'logged_in_user_id' => $loginuserid));
         DB::table('book')
             ->where('id', $id)
             ->increment('views', 1);
    }
    else
    {
      return abort(404);
    }

    $book_view_count = DB::table('books_view_count')->where('book_id',$id)->count();

    $amt = 0.002;
    $type = 'book';

    $created_at = date("Y-m-d");

    DB::table('transaction')
    ->insert(array(
      'user_id' => $auhthorId, 
      'amount' => $amt, 
      'type' => $type,
      'on_views' => $book_view_count,
      'date' => $created_at));

    DB::table('users')
    ->where('id', $auhthorId)
    ->increment('amount', $amt);

    DB::table('users')
    ->where('admin', 1)
    ->increment('amount', $amt);
  }
  

}else{

  // echo "testing3";   exit();
  $book_view_count = DB::table('books_view_count')->where('session_id',session()->getId())->where('book_id',$id)->count();

  if($book_view_count == 0)
  {
    // echo "testing2"; print_r($book_view_count); exit();
    if(preg_match('/^\d+$/',$id)) {
     DB::table('books_view_count')->insert(array('session_id' => session()->getId(), 'book_id' => $id));
        DB::table('book')
            ->where('id', $id)
            ->increment('views', 1);
   } else
   {
    return abort(404);
  }

  $book_view_count = DB::table('books_view_count')->where('book_id',$id)->count();
  // echo "testing1"; print_r($book_view_count); exit();
        //$amt = floor($book_view_count/1000) * 2;
  $amt = 0.002;
  $type = 'book';

  $created_at = date("Y-m-d");

  DB::table('transaction')
  ->insert(array(
    'user_id' => $auhthorId, 
    'amount' => $amt, 
    'type' => $type,
    'on_views' => $book_view_count,
    'date' => $created_at));

  DB::table('users')
  ->where('id', $auhthorId)
  ->increment('amount', $amt);

  DB::table('users')
  ->where('admin', 1)
  ->increment('amount', $amt);

}
// echo "<pre>"; echo "testing3ffdd========";  exit();
}
// echo "<pre>"; echo "testing55========";  exit();
$book_view_count = DB::table('books_view_count')->where('book_id',$id)->count();
$authors_view_count = $this->number_format_short($book_view_count);
// echo "<pre>"; print_r($book_view_count);  exit();
$chapters = Book::findorFail($id)->Chapters();

// echo "testing5"; print_r($chapters); exit();
// echo "<pre>testing5"; var_dump($chapters); exit();

$book = Book::find($id);
$bottomAd=ad::where('type', 'Bottom')->where('page','Chapters')->where('status','1')->get();
$topAd=ad::where('type', 'Top')->where('page','Chapters')->where('status','1')->get();

$restrictedlinks = DB::table('rlinks')->where('status',1)->orderByRaw('id DESC')->get();
$restrictedKeywords = DB::table('rkeywords')->where('status',1)->orderByRaw('id DESC')->get();
$afterTwoChapters = ad::where('type', 'aftertwochapters')->where('page','Chapters')->where('status','1')->get()->toArray();

return view('frontend/chapters')
->with('author',$author) 
->with('chapters',$chapters->paginate(10))
->with('book',$book)
->with('bottomAd',$bottomAd)
->with('topAd',$topAd)
->with('restrictedlinks',$restrictedlinks)
->with('restrictedKeywords',$restrictedKeywords)
->with('afterTwoChapters',$afterTwoChapters)
->with('book_view_count',$book_view_count);
}

public function read_book(Request $request, $author, $auhthorId , $book , $bookId, $chapterTitle , $id)
{
  $bottomAd=ad::where('type', 'Bottom')->where('page','reading_page')->where('status','1')->get();
  $topAd=ad::where('type', 'Top')->where('page','reading_page')->where('status','1')->get();
  $author = User::find($auhthorId);

  $chapter = Chapter::findOrFail($id);

  $book = Book::find($bookId);
  $rec_book=Book::where('genre',$book->genre)->with('user')->limit(10)->get();
  $chapterSlug = Chapter::where('slug',$chapterTitle)->first();


  $next_id_status = 0;
  $next_id_new = 0;
  $prev_id_new = 0;

  $chapters_dropdown = Chapter::where('book_id',$bookId)->orderBy('created_at','asc')->get();

  $get_all_chapters = Chapter::where('book_id',$bookId)->orderBy('book_id', 'asc')->get();

  foreach($get_all_chapters as $each_row)
  {

   if($id == $each_row->id)
   {
     $get_all_chapters_prev = Chapter::where('id', '<' ,$id)->where('book_id',$bookId)->orderBy('id', 'desc')->take(1)->get();

     $get_count = Chapter::where('id', '<' ,$id)->where('book_id',$bookId)->orderBy('id', 'desc')->take(1)->get()->count();

     if($get_count > 0)
     {
       $prev_id_new = $get_all_chapters_prev[0]->id;
     }
     else
     {
       $get_all_chapter_last = Chapter::where('book_id',$bookId)->orderBy('book_id', 'asc')->get();

       foreach($get_all_chapter_last as $each_row_chapter)
       {
        $prev_id_new = $each_row_chapter->id;
      }

    }
  }

  if($next_id_status == 1)
  {

   $next_id_new = $each_row->id;
   break;
 }
 if($id == $each_row->id && $next_id_status == 0)
 {
   $next_id_status = 1;
 }
}
if($next_id_new == 0)
{
 $get_all_chapter_first = Chapter::where('book_id',$bookId)->orderBy('book_id', 'asc')->first();
 $next_id_new = $get_all_chapter_first->id;
}

$lastChapterID = Chapter::where('book_id',$bookId)->orderBy('id', 'desc')->first();
$lastChapter = false;
if($lastChapterID->id == $id){
 $lastChapter = true;
}


$next_id = $next_id_new;

$prev_id = $prev_id_new; 

$next_chapter = Chapter::find($next_id);
$previous_chapter = Chapter::find($prev_id);
$comments = DB::table('comments')->where('chapter_id',$id)->where('approve','=',1)->where('status',1)->where('reply_to',0)->orderBy('id', 'desc')->get();

$commentss = [];
foreach($comments as $comment)
{
 $comment->replies = DB::table('comments')->where('chapter_id',$id)->where('approve','=',1)->where('status',1)->where('reply_to',$comment->id)->orderBy('id', 'desc')->get();
 $commentss[] = $comment;
}
$inChapterAd = ad::where('type', 'inChapters')->where('page','reading_page')->where('status','1')->limit(1)->get()->toArray();

$restrictedlinks = DB::table('rlinks')->where('status',1)->orderByRaw('id DESC')->get();
$restrictedKeywords = DB::table('rkeywords')->where('status',1)->orderByRaw('id DESC')->get();
          //return $commentss;

return view('frontend/read',compact('lastChapter','author','chapter','book','next_chapter','previous_chapter','bottomAd','topAd','commentss','inChapterAd','restrictedlinks','restrictedKeywords','rec_book','chapter_view_count','chapters_dropdown'));

}
public function read_books(Request $request, $auhthorId, $bookId, $id)
{
  $bottomAd=ad::where('type', 'Bottom')->where('page','reading_page')->where('status','1')->get();
  $topAd=ad::where('type', 'Top')->where('page','reading_page')->where('status','1')->get();
  $author = User::find($auhthorId);

  $chapter = Chapter::findOrFail($id);

  $book = Book::find($bookId);
  $rec_book=Book::where('genre',$book->genre)->with('user')->limit(10)->get();
  $chapterSlug = Chapter::where('slug',$chapterTitle)->first();

  $next_id_status = 0;
  $next_id_new = 0;
  $prev_id_new = 0;

  $chapters_dropdown = Chapter::where('book_id',$bookId)->orderBy('created_at','asc')->get();
  $get_all_chapters = Chapter::where('book_id',$bookId)->orderBy('book_id', 'asc')->get();

  foreach($get_all_chapters as $each_row)
  {

   if($id == $each_row->id)
   {
     $get_all_chapters_prev = Chapter::where('id', '<' ,$id)->where('book_id',$bookId)->orderBy('id', 'desc')->take(1)->get();

     $get_count = Chapter::where('id', '<' ,$id)->where('book_id',$bookId)->orderBy('id', 'desc')->take(1)->get()->count();

     if($get_count > 0)
     {
       $prev_id_new = $get_all_chapters_prev[0]->id;
     }
     else
     {
       $get_all_chapter_last = Chapter::where('book_id',$bookId)->orderBy('book_id', 'asc')->get();

       foreach($get_all_chapter_last as $each_row_chapter)
       {
        $prev_id_new = $each_row_chapter->id;
      }

    }
  }

  if($next_id_status == 1)
  {

   $next_id_new = $each_row->id;
   break;
 }
 if($id == $each_row->id && $next_id_status == 0)
 {
   $next_id_status = 1;
 }
}
if($next_id_new == 0)
{
 $get_all_chapter_first = Chapter::where('book_id',$bookId)->orderBy('book_id', 'asc')->first();
 $next_id_new = $get_all_chapter_first->id;
}

$lastChapterID = Chapter::where('book_id',$bookId)->orderBy('id', 'desc')->first();
$lastChapter = false;
if($lastChapterID->id == $id){
 $lastChapter = true;
}


$next_id = $next_id_new;

$prev_id = $prev_id_new; 

$next_chapter = Chapter::find($next_id);
$previous_chapter = Chapter::find($prev_id);
$comments = DB::table('comments')->where('chapter_id',$id)->where('approve','=',1)->where('status',1)->where('reply_to',0)->orderBy('id', 'desc')->get();

$commentss = [];
foreach($comments as $comment)
{
 $comment->replies = DB::table('comments')->where('chapter_id',$id)->where('approve','=',1)->where('status',1)->where('reply_to',$comment->id)->orderBy('id', 'desc')->get();
 $commentss[] = $comment;
}
$inChapterAd = ad::where('type', 'inChapters')->where('page','reading_page')->where('status','1')->limit(1)->get()->toArray();

$restrictedlinks = DB::table('rlinks')->where('status',1)->orderByRaw('id DESC')->get();
$restrictedKeywords = DB::table('rkeywords')->where('status',1)->orderByRaw('id DESC')->get();
          //return $commentss;

return view('frontend/read',compact('lastChapter','author','chapter','book','next_chapter','previous_chapter','bottomAd','topAd','commentss','inChapterAd','restrictedlinks','restrictedKeywords','rec_book','chapter_view_count','chapters_dropdown'));

}


public function admin_index() 
{
  if (Auth::user()->reader == 0 && Auth::user()->verified == 1) {
    if (Auth::user()->phone_verified == 0 && Auth::user()->phone != NULL) {
       return redirect()->route('enter-phone-code');
    }
  }
  
  $id= Auth::user()->id;

  $authors_count = DB::table('authors_view_count')
  ->where('user_id',$id)
  ->count();

  $authors_view_count =$authors_count;

//        $authors_view_count = count($authors_count);
  $authors_view_count = $this->number_format_short($authors_view_count);


  $author_books = DB::table('book')
  ->where('user_id',$id)
  ->get();
        //$author_books->count();

  $nobv = array();
  $nobv2 = array();

  foreach ($author_books as $value) {
   $nobv[] = DB::table('books_view_count')
    ->where('book_id', $value->id)
    ->count();
   $nobv2 = $nobv;
 }

 $total_book_views = array_sum($nobv2);
 $total_book_views = $this->number_format_short($total_book_views);
    //DB::enableQueryLog();
    /*
        $transaction_data = DB::table('transaction')
          ->select( DB::raw('SUM(amount) as amount'), DB::raw("CONCAT_WS('-',YEAR(date), MONTH(date)) as monthyear"))
          ->where('user_id', $id)
          ->where('on_views' ,'!=', 0)
          ->where('created_at','<','timestampadd(hour, -6, now())')
          ->groupby('monthyear')
          ->orderBy('monthyear', 'DESC')
          ->take(5)
          ->get();
    */
          $transaction_data = DB::table('transaction')
          ->select( DB::raw('SUM(amount) as amount'), DB::raw("CONCAT_WS('-',YEAR(date), MONTH(date)) as monthyear"))
          ->where('user_id', $id)
          ->where('on_views' ,'!=', 0)
          ->where('cron' ,'=', 1)
          ->groupby('monthyear')
          ->orderBy('monthyear', 'DESC')
          ->take(5)
          ->get();


    //dd(DB::getQueryLog());
          $user_data = DB::table('users')
          ->where('id', $id)
          ->get();


          if(Auth::user()->admin)
          {
            $payment_details = DB::table('transaction')
            ->join('users', 'users.id', '=' , 'transaction.user_id')
            ->select('transaction.*', 'users.name')
            ->where('transaction.admin_id', $id)
            ->orWhere('transaction.user_id', $id)
            ->where('transaction.on_views' ,'=', 0)
            ->orderBy('transaction.id', 'DESC')
            ->take(5)
            ->get();

    /*
    $user_details = array();
    foreach($payment_details as $pd){
      $user_details[] = array('id' => $pd->user_id,'name' => $pd->name);
    }
    $user_details = $user_details;
    */
    $user_details = DB::table('users')->get();

  }else{

    $payment_details = DB::table('transaction')
    ->join('users', 'users.id', '=' , 'transaction.admin_id')
    ->select('transaction.*', 'users.name')
    ->where('transaction.user_id', $id)
    ->where('transaction.on_views' ,'=', 0)
    ->orderBy('transaction.id', 'DESC')
    ->take(5)
    ->get();

          /*
    $user_details = array();
    foreach($payment_details as $pd){
      $user_details[] = array('id' => $pd->user_id,'name' => $pd->name);
    }
    $user_details = $user_details;  
    */
    $user_details = DB::table('users')->get();
    // if (Auth::user()->phone_verified == 0) {
    //   session()->flush();
    //   return redirect()->route('enter-phone-code');
    // }

  }
    //dd($payment_details);
  if (Auth::user()->reader == 1) {
    return view('admin.index_reader',compact('authors_view_count', 'total_book_views', 'transaction_data', 'user_data', 'payment_details', 'user_details'));
  }
  return view('admin.index',compact('authors_view_count', 'total_book_views', 'transaction_data', 'user_data', 'payment_details', 'user_details'));
}

public function showPVpage(){
  Auth::logout();
  return view('verify-phone');
}
public function verifyPhone(Request $request){
  $request->validate([
    'number_code' => 'required|max:6',
    'email' => 'required',
  ]);
  $data = $request->all();
  $code = User::where('email','=',$data['email'])->get()->toArray();
  if ($data['number_code'] == $code[0]['number_code']) {
    User::where('email','=',$data['email'])->update(['phone_verified'=>1]);
    return redirect()->route('login')->withSuccess('Thanks, your phone is verified');
  } else {
    return  view('email.verification',['email'=>$data['email']])->with('status','Invalid, Incorrect Pin!');
    // return redirect()->back()->withSuccess('Invalid, Incorrect Pin!');
  }
  
  // return view('verify-phone');
}

public function monthlyEarning()
{

  $id= Auth::user()->id;

  $transaction_data = DB::table('transaction')
  ->select( DB::raw('SUM(amount) as amount'), DB::raw("CONCAT_WS('-',YEAR(date), MONTH(date)) as monthyear"))
  ->where('user_id', $id)
  ->where('on_views' ,'!=', 0)
  ->groupby('monthyear')
  ->orderBy('monthyear', 'DESC')
  ->simplePaginate(12);

  return view('admin.payment.monthly',compact('transaction_data'));
}

public function paymentDetails()
{
  $id = Auth::user()->id;
  if(Auth::user()->admin)
  {
    $payment_details = DB::table('transaction')
    ->join('users', 'users.id', '=' , 'transaction.user_id')
    ->select('transaction.*', 'users.name')
    ->where('transaction.admin_id', $id)
    ->orWhere('transaction.user_id', $id)
    ->where('transaction.on_views' ,'=', 0)
    ->orderBy('transaction.id', 'DESC')
    ->paginate(12);

    $user_details = DB::table('users')->get();

  }else{

    $payment_details = DB::table('transaction')
    ->join('users', 'users.id', '=' , 'transaction.admin_id')
    ->select('transaction.*', 'users.name')
    ->where('transaction.user_id', $id)
    ->where('transaction.on_views' ,'=', 0)
    ->orderBy('transaction.id', 'DESC')
    ->paginate(12);
    $user_details = DB::table('users')->get();
  }

  return view('admin.payment.paymentdetails',compact('payment_details', 'user_details'));
}

public function bankDetails()
{
  if(!Auth::user()->admin){
    $id = Auth::user()->id;

    $bank_details = Bankdetail::where('user_id', $id)->get();
    return view('admin.payment.bankdetails', compact('bank_details'));
  }else{
    return redirect()->back();
  }
}

public function bankAddForm()
{
 if(!Auth::user()->admin){

  $id = Auth::user()->id;
  $chkquery = DB::table('bank_details')->where('user_id', $id)->exists();
  if($chkquery == true){
    return redirect()->back();
  }
  return view('admin.payment.addbank');
}else{
  return redirect()->back();
}
}

public function bankAddDetails(Request $request)
{
  if(!Auth::user()->admin){
    $id = Auth::user()->id;
    $rules = [
      'name'=> 'required',
      'surname' => 'required',
      'bank_name' => 'required',
      'account_number' => 'required',
      'branch' => 'required',
    ];

    $customMessages = [
      'name.required' => 'Name cannot be blank',
      'surname.required' => 'Surname cannot be blank',
      'bank_name.required' => 'Bank name cannot be blank',
      'account_number.required' => 'Account Number cannot be blank',
      'branch.required' => 'Branch cannot be blank',
    ];

    $this->validate($request, $rules, $customMessages);
    $input = array();
    $input['user_id'] = $id;
    $input['name'] = $request->name;
    $input['surname'] = $request->surname;
    $input['bank_name'] = $request->bank_name;
    $input['account_number'] = $request->account_number;
    $input['branch'] = $request->branch;

    DB::table('bank_details')->insert($input);
    Session::flash('success','Bank Details Added Successfuly');
    return redirect('/admin/bank/details');
  }else{
    return redirect()->back();
  }
}

public function bankEditForm($id)
{
  if(!Auth::user()->admin){
    $bankData = Bankdetail::where('id', $id)->get();
    return view('admin.payment.editbank', compact('bankData'));
  }else{
    return redirect()->back();
  }
}

public function adminLogin(){
    echo "testing-testing"; exit();
  if(!Auth::user()->admin){
   redirect('login');
 }else{
   redirect('login');
 }
}

public function bankUpdateDetails(Request $request)
{
  if(!Auth::user()->admin){
    $id = Auth::user()->id;
    $rules = [
      'name'=> 'required',
      'surname' => 'required',
      'bank_name' => 'required',
      'account_number' => 'required',
      'branch' => 'required',
    ];

    $customMessages = [
      'name.required' => 'Name cannot be blank',
      'surname.required' => 'Surname cannot be blank',
      'bank_name.required' => 'Bank Name cannot be blank',
      'account_number.required' => 'Account Number cannot be blank',
      'branch.required' => 'Branch cannot be blank',
    ];

    $this->validate($request, $rules, $customMessages);
    $bank_id = $request->input('bank_id');
    $input = array();
    $input['user_id'] = $id;
    $input['name'] = Str::random(5).base64_encode($request->name);
    $input['surname'] = Str::random(5).base64_encode($request->surname);
    $input['bank_name'] = Str::random(5).base64_encode($request->bank_name);
    $input['account_number'] = Str::random(5).base64_encode($request->account_number);
    $input['branch'] = Str::random(5).base64_encode($request->branch);

    DB::table('bank_details')->where('id', $bank_id)
    ->update($input);
    Session::flash('success','Bank Details Updated Successfuly');
    return redirect('/admin/bank/details');
  }else{
    return redirect()->back();
  }
}


public function requestPayment(Request $request, $id){

  if(!Auth::user()->admin)
  {
    $chkqry = DB::table('users')
    ->where('id', $id)
    ->where('amount' ,'>=', 250)
    ->get();
    $user_id = $chkqry[0]->id;
    $user_name = $chkqry[0]->name;
    $user_email = $chkqry[0]->email;
    $user_amount = $chkqry[0]->amount;

    $get_bank_details = Bankdetail::where('user_id', $chkqry[0]->id)
    ->get();
    
    
    $name = $get_bank_details[0]->name;
    $surname = $get_bank_details[0]->surname;
    $bank_name = $get_bank_details[0]->bank_name;
    $account_number = $get_bank_details[0]->account_number;
    $branch = $get_bank_details[0]->branch;

    $data = array(
      'id' => $user_id,
      'name' => $user_name,
      'email' => $user_email,
      'current_balance' => $user_amount,
      'username' => $name,
      'surname' => $surname,
      'bank_name' => $bank_name,
      'account_no' => $account_number,
      'branch' => $branch,
    );

    Mail::send('request_payment_mail', $data, function($message) use ($data){
      $message->to('authors@visionarywritings.com', 'Visionary Writings')
      ->subject('Payment Request');
      $message->from($data['email'], $data['name'].$data['id'].$data['email']);
    });

    Session::flash('success','Payment Request Sent Successfully');
    return redirect()->back();

  }else{
    return redirect()->back();
  }
  

}




public function search($slug)
{
  $chapterSlug = Chapter::where('slug',$slug)->first();
  $next_id = Chapter::where('id', '>', $chapterSlug->id)->min('id');
  $prev_id = Chapter::where('id', '<', $chapterSlug->id)->max('id');
  return view('frontend/chapters',compact('next',Chapter::find($next_id),'prev',Chapter::find($prev_id)));
}
public function import(Request $request)  
{
 if($request->file('bbok'))
 { 
  $path = $request->file('bbok')->getRealPath();
  $data = Excel::load($path, function($reader)
  {
  })->get();

  if(!empty($data) && $data->count())
  {
    foreach ($data as $row)
    {
      if(!empty($row))
      {
        dd($row);
            //     $dataArray[] =
            //     [
            //       'title' => $row["posttitle"],
            //       'chapter_content' => $row["postcontent"],
            //       'book_id' => $request->book_id,
            //       'slug' => $row["posttitle"],
            //       'book_id' =>1
            //     ];
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




function number_format_short($num) {

  if ($num <= 999.999) {
    return $num;
  }
  $x = round($num);
  $x_number_format = number_format($x);
  $x_array = explode(',', $x_number_format);
  $x_parts = array('K', 'M', 'B', 'T');
  $x_count_parts = count($x_array) - 1;
  $x_display = $x;
  $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
  $x_display .= $x_parts[$x_count_parts - 1];

  $num = $x_display;
  return $num;
}



}
