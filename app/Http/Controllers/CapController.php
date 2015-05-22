<?php namespace App\Http\Controllers;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Cap;

class CapController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Search CAP
	 *
	 * @return Response
	 */
	public function search()
	{
		$query = Request::get('query');

		$caps = Cap::selectRaw('cap as id, CONCAT(cap, \' - \', name) AS full_name')
			->where('cap', 'like', $query . '%')
			->orWhere('name', 'like', '%' . $query . '%')
			->take(10)
			->get();

		return $caps;
	}
}
