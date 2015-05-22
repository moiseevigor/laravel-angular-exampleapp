<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\Form;
use App\FormField;
use App\Order;
use App\OrderField;

class OrderController extends Controller {

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
		return view('order.index', array(
			'forms' => Form::all(),
			'orders' => Order::all()
			));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($formId)
	{
		$form = Form::findOrFail($formId);
		$fields = $form->form_field->sortBy(function($field) {
			return $field->order;
		});
		$fields = $this->get_fields_html($fields);

		return view('order.create', array(
			'form' => $form,
			'order_fields' => $fields
			));
	}

	/**
	 * Get the field html
	 *
	 * @return Response
	 */
	public function get_fields_html($fields)
	{
		foreach ($fields as $key => $field) {
			$id = $field->form_id . '-' . $field->order . '-' . $field->cid;

			$fields[$key]['html'] = '';
			$options = json_decode($field['field_options']);

			switch($field['field_type']) {
				case 'text':
					$fields[$key]['html'] = 
						"<input name='{$id}' type='text' class='form-control rf-size-{$options->size}'/>";
				break;

				case 'radio':
					foreach ($options->options as $option) {
						$fields[$key]['html'] .= 
						 "<div class='col-lg-5' style='padding-left: 0;'>
							<div class='input-group'>
							  <span class='input-group-addon'>
								<input name='{$id}' type='radio' aria-label='{$option->label}'>
							  </span>
							  <input type='text' class='form-control' value='{$option->label}' onkeypress='return false;'>
							</div>
						  </div>";
					}
				break;

				case 'dropdown':
					$fields[$key]['html'] .= "<select name='{$id}' class='form-control'>";
					foreach ($options->options as $option) {
						$fields[$key]['html'] .= 
							"<option value='{$option->label}'>{$option->label}</option>";
					}
					$fields[$key]['html'] .= '</select>';
				break;

				case 'price':
					$fields[$key]['html'] = 
						"<input name='{$id}' type='text' class='form-control rf-size-small'/>";
				break;

				case 'cap':
					$fields[$key]['html'] .= 
						"<input id='{$id}' name='{$id}' type='text' data-provide='typeahead' class='form-control cap' />";
				break;

				case 'checkboxes':
					foreach ($options->options as $option) {
						$fields[$key]['html'] .= 
						 "<div class='col-lg-5' style='padding-left: 0;'>
							<div class='input-group'>
							  <span class='input-group-addon'>
								<input name='{$id}' type='checkbox' aria-label='{$option->label}'>
							  </span>
							  <input type='text' class='form-control' value='{$option->label}' onkeypress='return false;'>
							</div>
						  </div>";
					}
				break;

				case 'paragraph':
						$fields[$key]['html'] .= 
						 "<textarea name='{$id}' class='form-control'></textarea>";
				break;

			}
		}

		return $fields;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($formId)
	{
		$order = new Order(array(
			'user_id' => Auth::user()->id,
			'form_id' => $formId
			));
		$order->save();

		$orderFieldsData = Request::all();
		

		return redirect(action('OrderController@index'));
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
	public function edit($id)
	{
		//
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
	public function destroy($id)
	{
		//
	}

}
