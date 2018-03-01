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
use App\Models\MaritalStatus;

class MaritalStatusController extends Controller
{
	public function index()
	{
		$maritalStatus=MaritalStatus::orderBy('id', 'ASC')->paginate(20);
		return response()->json($maritalStatus);
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
			"code" => 'required',
			"display" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator);
		} else {
			$maritalStatus= new MaritalStatus;
			$maritalStatus->code = $request->input('code');
			$maritalStatus->display = $request->input('display');
			$maritalStatus->definition = $request->input('definition');

			try{
				$maritalStatus->save();
				return response()->json($maritalStatus);
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
		$maritalStatus=MaritalStatus::findOrFail($id);
		return response()->json($maritalStatus);
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
			"code" => 'required',
			"display" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator,422);
		} else {
			$maritalStatus=MaritalStatus::findOrFail($id);
			$maritalStatus->code = $request->input('code');
			$maritalStatus->display = $request->input('display');
			$maritalStatus->definition = $request->input('definition');

			try{
				$maritalStatus->save();
				return response()->json($maritalStatus);
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
			$maritalStatus=MaritalStatus::findOrFail($id);
			$maritalStatus->delete();
			return response()->json($maritalStatus,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}