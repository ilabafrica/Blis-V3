<?php
namespace App\Http\Controllers;
/**
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use Illuminate\Http\Request;
use App\Models\AdhocOption;

class AdhocOptionController extends Controller
{
	public function index()
	{
		$adhocOption=AdhocOption::orderBy('id', 'ASC')->paginate(20);
		return response()->json($adhocOption);
	}

	/**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request
    * @return \Illuminate\Http\Response
    */
	public function store(Request $request)
	{
		$rules = array(
			"adhoc_category_id" => 'required',
			"display" => 'required',
		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator);
		} else {
			$adhocOption= new AdhocOption;
			$adhocOption->adhoc_category_id = $request->input('adhoc_category_id');
			$adhocOption->code = $request->input('code');
			$adhocOption->display = $request->input('display');

			try{
				$adhocOption->save();
				return response()->json($adhocOption);
			}
			catch (\Illuminate\Database\QueryException $e){
				return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
			}
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		$adhocOption=AdhocOption::findOrFail($id);
		return response()->json($adhocOption);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  request
	 * @param  int  id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$rules=array(
			"adhoc_category_id" => 'required',
			"display" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator,422);
		} else {
			$adhocOption=AdhocOption::findOrFail($id);
			$adhocOption->adhoc_category_id = $request->input('adhoc_category_id');
			$adhocOption->code = $request->input('code');
			$adhocOption->display = $request->input('display');

			try{
				$adhocOption->save();
				return response()->json($adhocOption);
			}
			catch (\Illuminate\Database\QueryException $e){
				return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
			}
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id){
		try{
			$adhocOption=AdhocOption::findOrFail($id);
			$adhocOption->delete();
			return response()->json($adhocOption,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}