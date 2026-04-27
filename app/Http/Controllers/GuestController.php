<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;
class GuestController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('auth.main', ['page_name' => 'main']);
	}

	public function getUserName()
	{
		return view('auth.username', [ 'page_name' => 'username']);
	}


	public function search()
	{
		return view('search', [ 'page_name' => 'search']);
	}

	public function searchResults(Request $request)
	{
		$request->validate([
			'search_query' => 'nullable|string|max:100',
		]);

		$query = $request->only('search_query');

		$results = DB::select('SELECT * FROM music WHERE song_name LIKE ? LIMIT 20', ["%".$query['search_query']."%"]);

		if($results){
			return view('search-results', [ 'data' => $results, 'page_name' => 'searchResults']);
		}
		else{
			return view('search-results', [ 'data' => 0, 'page_name' => 'searchResults']);
		}

	}

	public function postUserName(Request $request){
		$request->validate([
			'honeypot' => 'required|in:IS-421-RRZ',
			'email' => 'required|email|max:50',
		]);

		$userEmail = $request->only('email');


		$results = DB::select('SELECT user FROM users WHERE email = ?', [$userEmail['email']]);


		//$eMessage = "Your username is ".$results[0]['user'];
		

		if($results){
			$eMessage = "Your username is ".$results[0]->user;
			Mail::raw($eMessage, function($message) use ($userEmail){

				$message->to($userEmail['email'])->subject('User Name Retrieval!');
			});
			return redirect()->route('/auth/login')->with('status', 'Username sent to your email.');
			//return view('auth.login', [ 'page_name' => 'login']);
		}
		else{
			return redirect()->route('/auth/login')->with('status', 'There was a problem with sending username retrieval email, please try again.');
			//return view('auth.username', [ 'page_name' => 'username']);
		}

	}

}
