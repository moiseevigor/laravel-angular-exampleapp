<?php namespace App\Http\Controllers;

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
			'users' => \app\User::all()
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
		return view('user.edit', array(
			'user' => \app\User::findOrFail($userId)
			));
	}

	/**
	 * Update User action
	 *
	 * @return Response
	 */
	public function update($userId)
	{
		return view('user.update', array(
			'user' => \app\User::findOrFail($userId)
			));
	}

	/**
	 * Store User data
	 *
	 * @return Response
	 */
	public function store()
	{
		return view('user.create');
	}

	/**
	 * Destoy User
	 *
	 * @return Response
	 */
	public function destoy($userId)
	{
		return view('user.create');
	}
}
