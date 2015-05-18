<?php namespace App\Http\Controllers;

use Auth;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\UpdateUserFormRequest;
use App\Http\Requests\StoreUserFormRequest;
use App\Role;
use App\User;
use App\UserForm;

class UserFormController extends Controller {

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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('userform.index', array(
			'user_form' => UserForm::all()
			));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('userform.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StoreUserFormRequest $requests)
	{
		$userFormData = Request::all();
		$userFormData['user_id'] = Auth::user()->id;

		$user_form = new UserForm($userFormData);
 		$user_form->save();
		return redirect(action('UserFormController@edit', ['formId' => $user_form->id]));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($formId)
	{
		return view('userform.edit', [
			'form' => UserForm::findOrFail($formId)
			]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($formId)
	{
		$user_form = UserForm::findOrFail($formId);
		$user_form->delete();
	}

}
