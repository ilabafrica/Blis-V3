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
use App\Models\SusceptibilityRange;

class SusceptibilityRangeController extends Controller
{
	public function index()
	{
		$susceptibilityRange=SusceptibilityRange::orderBy('id', 'ASC')->paginate(20);
		return response()->json($susceptibilityRange);
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
			"name" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator);
		} else {
			$susceptibilityRange= new SusceptibilityRange;
			$susceptibilityRange->code = $request->input('code');
			$susceptibilityRange->name = $request->input('name');

			try{
				$susceptibilityRange->save();
				return response()->json($susceptibilityRange);
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
		$susceptibilityRange=SusceptibilityRange::findOrFail($id);
		return response()->json($susceptibilityRange);
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
			"name" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator,422);
		} else {
			$susceptibilityRange=SusceptibilityRange::findOrFail($id);
			$susceptibilityRange->code = $request->input('code');
			$susceptibilityRange->name = $request->input('name');

			try{
				$susceptibilityRange->save();
				return response()->json($susceptibilityRange);
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
			$susceptibilityRange=SusceptibilityRange::findOrFail($id);
			$susceptibilityRange->delete();
			return response()->json($susceptibilityRange,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}