<?php namespace App\Http\Controllers;

use Auth, Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role, App\User, App\Form, App\FormField, App\Order, App\OrderField;

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
	public function get_field_html($field, $id)
	{
		$html = '';
		$options = json_decode($field['field_options']);
		$value = '';

		if(isset($field->value))
			$value = $field->value;

		switch($field['field_type']) {
			case 'text':
				$html = 
					"<input name='{$id}' type='text' class='form-control rf-size-{$options->size}' value='{$value}'/>";
			break;

			case 'radio':
				foreach ($options->options as $option) {
					$checked = '';
					if($value === '')
						$value = $option->label;
					elseif($value === $option->label)
						$checked = 'checked';

					$html .= 
					 "<div class='col-lg-5' style='padding-left: 0;'>
						<div class='input-group'>
						  <span class='input-group-addon'>
							<input name='{$id}' type='radio' aria-label='{$option->label}' value='{$option->label}' {$checked}>
						  </span>
						  <input type='text' class='form-control' value='{$option->label}' onkeypress='return false;'>
						</div>
					  </div>";
				}
			break;

			case 'dropdown':
				$html .= "<select name='{$id}' class='form-control'>";
				foreach ($options->options as $option) {
					$selected = '';
					if($option->label === $value)
						$selected = 'selected';

					$html .= 
						"<option value='{$option->label}' {$selected}>{$option->label}</option>";
				}
				$html .= '</select>';
			break;

			case 'price':
				$html = 
					"<input name='{$id}' type='text' class='form-control rf-size-small'/>";
			break;

			case 'cap':
				$html .= 
					"<input id='{$id}' name='{$id}' type='text' data-provide='typeahead' class='form-control cap' value='{$value}'/>";
			break;

			case 'checkboxes':
				$html .= "<input name='{$id}[]' type='hidden' value=''>";
				foreach ($options->options as $option) {
					$checked = '';
					if($value === '')
						$value = $option->label;
					else {
						if(!is_array($value))
							$value = json_decode($value);
						
						if(!is_null($value) && in_array($option->label, $value))
							$checked = 'checked';
					}
					$html .= 
					 "<div class='col-lg-5' style='padding-left: 0;'>
						<div class='input-group'>
						  <span class='input-group-addon'>
							<input name='{$id}[]' type='checkbox' aria-label='{$option->label}' value='{$option->label}' {$checked}>
						  </span>
						  <input type='text' class='form-control' value='{$option->label}' onkeypress='return false;'>
						</div>
					  </div>";
				}
			break;

			case 'paragraph':
					$html .= 
					 "<textarea name='{$id}' class='form-control'>{$value}</textarea>";
			break;

		}

		return $html;
	}

	/**
	 * Get the field html
	 *
	 * @return Response
	 */
	public function get_fields_html($fields)
	{
		foreach ($fields as $key => $field)
		{
			if(isset($field->value))
				$id = $field->id;
			else
				$id = $field->form_id . '-' . $field->order . '-' . $field->cid;

			$fields[$key]['html'] = $this->get_field_html($field, $id);
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
		$orderObj = new Order(array(
			'user_id' => Auth::user()->id,
			'form_id' => $formId
			));
		$orderObj->save();

		$orderFieldsData = Request::all();
		unset($orderFieldsData['_token']);

		foreach ($orderFieldsData as $key => $field_value)
		{
			list($form_id, $order, $cid) = explode('-', $key);
			$formField = FormField::findByPk($form_id, $order, $cid);

			$orderField = new OrderField();
			$orderField->order_id = $orderObj->id;
			$orderField->label = $formField->label;
			$orderField->field_type = $formField->field_type;
			$orderField->required = $formField->required;
			$orderField->field_options = $formField->field_options;

			if(is_string($field_value))
				$orderField->value = $field_value;
			else
				$orderField->value = json_encode($field_value);

			$orderField->save();
		}

		return redirect(action('OrderController@index'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($formId, $orderId)
	{
		$form = Form::findOrFail($formId);
		$order = Order::findOrFail($orderId);

		$fields = $order->order_field->sortBy(function($field) {
			return $field->id;
		});
		$fields = $this->get_fields_html($fields);

		return view('order.edit', array(
			'form' => $form,
			'order_fields' => $fields,
			'order' => $order
			));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($formId, $orderId)
	{
		$orderFieldsData = Request::all();
		unset($orderFieldsData['_token']);

		foreach ($orderFieldsData as $id => $field_value)
		{
			$orderField = OrderField::findOrFail($id);
	
			if(is_string($field_value))
				$orderField->value = $field_value;
			else
				$orderField->value = json_encode($field_value);

			$orderField->save();
		}

		return redirect(action('OrderController@index'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($formId, $orderId)
	{
		$order = Order::findOrFail($orderId);
		$order->delete();
	}

}
