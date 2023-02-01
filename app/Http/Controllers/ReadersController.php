<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\profile;
use App\Book;
use App\Chapter;
use Session;
use Excel;
use Image; 
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Jobs\NotifyUsersForAccountActivation;
use Illuminate\Support\Facades\DB;

class ReadersController extends Controller

{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function __construct()
	{
		$this->middleware('admin');
	}

	public function index()
	{
		$users = User::where('active','1')->where('reader','1')->where('admin','0')->orderBy('id','desc');
		
		$searchTerm = isset($_REQUEST['search_text']) ? $_REQUEST['search_text'] : '';

		if (isset($_REQUEST['search']) && $_REQUEST['search'] == 'Reset') {
			$searchTerm = '';
		}

		if ($searchTerm != '') {
			$users = $users->where('name', 'LIKE', '%'.$searchTerm.'%');
			$users = $users->orWhere('email', 'LIKE', '%'.$searchTerm.'%');
		}

		$users = $users->paginate(25);
		//echo "<pre>";print_r($users);exit;
		return view('admin.readers.index', compact('users', 'searchTerm'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.users.create')->with('user',array());;
	}

	public function registered()
	{
		
		$users = User::where('active',0)->orderBy('id','desc');

		$searchTerm = isset($_REQUEST['search_text']) ? $_REQUEST['search_text'] : '';

		if (isset($_REQUEST['search']) && $_REQUEST['search'] == 'Reset') {
			$searchTerm = '';
		}

		if ($searchTerm != '') {
			$users = $users->where('name', 'LIKE', '%'.$searchTerm.'%');
			$users = $users->orWhere('email', 'LIKE', '%'.$searchTerm.'%');
		}

		$users = $users->paginate(25);
		return view('admin.users.registered', compact('users', 'searchTerm'));
	}

	public function activate($id)
	{
		$user = User::find($id);
		dispatch(new NotifyUsersForAccountActivation($user));
		$data['active'] = $user->active = '1';
		$user->update($data);
		Session::flash('success','Email sent and user is active');
		return redirect()->back();
	}
	public function multi_activate($id)
	{
		$user = User::find($id);
		dispatch(new NotifyUsersForAccountActivation($user));
		$data['active'] = $user->active = '1';
		$user->update($data);
		Session::flash('success','Email sent and user is active');
		return redirect()->back();
	}

	public function deactivate($id)
	{
		$user = User::find($id);
		dispatch(new NotifyUsersForAccountActivation($user));
		$data['active'] = $user->active = '0';
		$user->update($data);
		Session::flash('success','Email sent and user is active');
		return redirect()->back();
	}
	public function delete($id)
	{
		
		$user = User::find($id);
		//$user->delete();
		Session::flash('success','User deleted successfuly'); 
		return redirect()->back();
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		
		

		/*if ($request->hasFile('import-users'))
		{
			
			$this->validate($request, ['import-users' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 'name' => 'required', 'email' => 'required|email']);
			
			$image = $request->file('import-users');
			$avatar = time() . '_' . str_random(6) . '.' . strtolower($image->getClientOriginalExtension());
			Image::make($image)->save(public_path('books/avatars/') . $avatar, 100);
			
			$user = User::create(['name' => $request->name, 'email' => $request->email,'password' => Hash::make('password'),'active' => 1,'verified' => 1]);
			$profile = profile::create(['user_id' => $user->id, 'avatar' => $avatar,'dob' => $request->dob,'gender' => $request->gender]);
			Session::flash('success', 'User added successfuly');
			return redirect()->route('users');
 
		}else{*/

			$this->validate($request, ['name' => 'required', 'email' => 'required|email']);


			 if(!empty($request->user_id)){
           
            		$user = User::findOrFail($request->user_id);
            		
            		 if($request->hasFile('avatar')){
			            $image=$request->avatar;
			            $avatar=time().'_'.str_random(6).'.'.strtolower($image->getClientOriginalExtension()); 
			            Image::make($image)->save(public_path('books/avatars/').$avatar);
			            $user->profile->avatar=$avatar;
			            $user->profile->save();
			        }

			        if($request->has('avatar')){
			            $avatar = $request->avatar;
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
			         if($request->has('about')){
			            $user->profile->about=$request->about;
			            $user->profile->save();
			        }

			        $user->name=$request->name;
			        $user->email=$request->email;
			        $user->save();

			        $user->profile->save();
			        Session::flash('success','User updated successfuly');

	        }else{  
	            	$user = User::create(['name' => $request->name, 'email' => $request->email,'active' => 1,'verified' => 1,'password' => Hash::make('password')]);
				$profile = profile::create(['user_id' => $user->id, 'avatar' => $request->avatar,'about' => $request->about,'dob' => $request->dob,'gender' => $request->gender]);
				Session::flash('success', 'User added successfuly');

	        }

			

			
			return redirect()->route('users');
		/*}*/
		
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
		$user = User::find($id);
		
		return view('admin.users.create')->with('user',$user);
	}

	public function login($id)
	{
		$user = User::find($id);

		Auth::login($user);
		
		return redirect()->to('/');
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

		//

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		
		$user = User::find($id);
		foreach($user->books as $book)
		{
			foreach($book->Chapters as $trash_Chapters)
			{
				$Chapter =Chapter::find($trash_Chapters['id']);
				$Chapter->forceDelete();

			}
			$Book =Book::find($book['id']);
			$book->forceDelete();
		}
		$user->profile->delete();
		$user->delete();
		Session::flash('success', 'User deleted successfuly');
		return redirect()->back();
	}

	public function admin($id)
	{
		$user = User::find($id);
		$user->admin = 1;
		$user->save();
		Session::flash('success', 'User permission changed');
		return redirect()->back();
	}

	public function not_admin($id)
	{
		$user = User::find($id);
		$user->admin = 0;
		$user->save();
		Session::flash('success', 'User permission changed');
		return redirect()->back();
	}

	public function importUsers(Request $request)
	{
		if ($request->file('usersFile') && $request->ajax())
		{
			$path = $request->file('usersFile')->getRealPath();
			$data = Excel::load($path,
			function ($reader)
			{
			})->get();
			if (!empty($data) && $data->count())
			{
				foreach($data->toArray() as $row)
				{
					if (!empty($row))
					{
						$dataArray[] = ['name' => $row['username'], 'email' => $row['user_email'], 'password' => $row['user_pass'], 'admin' => 0];
					}
				}

				if (!empty($dataArray))
				{
					User::insert($dataArray);
					$users = User::all();
					$rows = $data->toArray();
					foreach($users as $i => $user)
					{
						if (!$user->admin)
						{
							$Data[] = ['user_id' => $user->id, 'avatar' => 'avatar.png', 'about' => isset($rows[$i]['description']) ? $rows[$i]['description'] : 'Author has no bio'];
						}
					}

					profile::insert($Data);
					return response('success');
					return back();
				}
			}
		}
	}

	public function destroyByIds(Request $request)
	{ 
		$data = $request->all();
		
		$id ="";
		if(!Auth::check())
		{
			return redirect()->to('/');
		}
		else
		{
			switch ($data['selectedOption']) {
				case 'Trash':
					foreach ($data['userids'] as $key => $value) {
									$user = User::find($value)->delete();
									$user = Profile::where('user_id','=',$value)->delete();
								}
					break;
				case 'Deactivate':
					foreach ($data['userids'] as $key => $value) {
									$user = User::find($value);
									// dispatch(new NotifyUsersForAccountActivation($user));
									$data['active'] = $user->active = '0';
									$user->update($data);
								}
					break;
				case 'Activate':
					foreach ($data['userids'] as $key => $value) {
									$user = User::find($value);
									// dispatch(new NotifyUsersForAccountActivation($user));
									$data['active'] = $user->active = '1';
									$user->update($data);
								}
					break;
				default:
					# code...
					break;
			}
			
		}	
		// $id = rtrim($id, ", ");

		// echo $id;
		// $book = DB::table('book')
		// ->whereIn('id', (string)$id)
		// ->update(['status' => 0]);
		// ;

		Session::flash('success', 'books and content trashed successfuly');
		return "DONE";
	}
}

