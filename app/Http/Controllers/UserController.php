<?php namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Role;
use App\User;

class UserController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| User Controller
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the user list
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('user.index', array(
			'users' => User::all()
			));
	}

	/**
	 * User Create form
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('user.create');
	}

	/**
	 * User Edit form
	 *
	 * @return Response
	 */
	public function edit($userId)
	{
		$user = User::findOrFail($userId);

		return view('user.edit', array(
			'user' => $user
			));
	}

	/**
	 * Update User action
	 *
	 * @return Response
	 */
	public function update($userId, UpdateUserRequest $request)
	{
		$userData = Request::all();

		$user = User::findOrFail($userId);
		$user->role_id = $userData['role_id'];
		$user->name = $userData['name'];
		$user->email = $userData['email'];
		$user->password = Hash::make($userData['password']);
		$user->save();

		return redirect(action('UserController@index'));
	}

	/**
	 * Store New User data
	 *
	 * @return Response
	 */
	public function store(StoreUserRequest $request)
	{
		$user = new User(Request::all());
 		$user->save();
		return redirect(action('UserController@index'));
	}

	/**
	 * Destoy User
	 *
	 * @return Response
	 */
	public function destroy($userId)
	{
		$user = User::findOrFail($userId);
		$user->delete();
	}
}
