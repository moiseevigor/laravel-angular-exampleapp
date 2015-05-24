<?php namespace App\Http\Controllers;

use Auth, Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\UpdateFormRequest;
use App\Http\Requests\StoreFormRequest;
use App\Role, App\User, App\Form, App\FormField;

class FormController extends Controller {

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
		return view('form.index', array(
			'forms' => Form::all()
			));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('form.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StoreFormRequest $requests)
	{
		$formData = Request::all();
		$formData['user_id'] = Auth::user()->id;

		$form = new Form($formData);
 		$form->save();
		return redirect(action('FormController@edit', ['formId' => $form->id]));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($formId)
	{
		return view('form.edit', [
			'form' => Form::findOrFail($formId)
			]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($formId, UpdateformRequest $request)
	{
		$formData = Request::all();
		$form_json = json_decode($formData['form_json'], true);

		$form = Form::findOrFail($formId);
		$form->form_json = json_encode($form_json['fields']);
		$form->save();

		FormField::where('form_id', '=', $form->id)->delete();

		$formFieldData = $form_json['fields'];

		foreach ($form_json['fields'] as $key => $field) {
			$formField = new FormField();
			$formField->form_id = $form->id;
			$formField->cid = $field['cid'];
			$formField->order = $key;
			$formField->label = $field['label'];
			$formField->field_type = $field['field_type'];
			$formField->required = $field['required'];
			$formField->field_options = json_encode($field['field_options']);
			$formField->save();
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($formId)
	{
		$form = Form::findOrFail($formId);
		$form->delete();
	}

}
