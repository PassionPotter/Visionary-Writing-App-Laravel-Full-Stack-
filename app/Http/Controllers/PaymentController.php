<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Image; 
use Auth;
use App\Book;
use App\Chapter;
use Session;
use DB;


class PaymentController extends Controller

{
	public function __construct()
	{
		$this->middleware('admin');
	}

	public function paymentForm()
	{
		$loginuserid = Auth::user()->id;

		$query = new User;
		$all_user = $query
		->where('admin', 0)
		->where('id' ,'!=', $loginuserid)
		->where('active', 1)
		->where('verified', 1)
		->orderBy('name', 'ASC')
		->get();

		$query2 = new User;
		$admin_details = $query2
		->where('admin', 1)
		->where('id', $loginuserid)
		->get();

		return view('admin.payment.paymentform', compact('all_user', 'admin_details'));

	}

	public function paymentAmount(Request $request)
	{
		$admin_id = Auth::user()->id;

		$admin_amt = $request->input('admin_amt');
		$this->validate($request, ['user' => 'required', 'amount' => 'required']);
		$user_id = $request->input('user');
		$pay_amt = $request->input('amount');

		if($pay_amt > $admin_amt){
			return redirect()
			->back()
			->with('error_msg', 'You do not have enough money to pay! Your current wallet balance is R'.$admin_amt)
			->withInput();

		}else{


			$type = 'debit';

			DB::table('transaction')
			->insert(array(
				'admin_id' => $admin_id, 
				'user_id' => $user_id, 
				'amount' => $pay_amt, 
				'type' => $type,
				));
			
			DB::table('users')
			->where('id', $user_id)
			->decrement('amount', $pay_amt);

			DB::table('users')
			->where('admin', 1)
			->decrement('amount', $pay_amt);

			Session::flash('success','Transaction Successful');
       return redirect('admin/payment/details');
		}
		

	}

	
}
