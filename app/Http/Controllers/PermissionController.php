<?php namespace App\Http\Controllers;

use Auth, Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role, App\User, App\Form, App\FormField, App\Order, App\OrderField;

class PermissionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('permission', array(
			'errors' => array('Permission error')));
	}

}
