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
use App\Models\Telecom;

class TelecomController extends Controller
{
	public function index()
	{
		$telecom=Telecom::orderBy('id', 'ASC')->paginate(20);
		return response()->json($telecom);
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
			"patient_id" => 'required',
			"system" => 'required',
			"value" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator);
		} else {
			$telecom= new Telecom;
			$telecom->patient_id = $request->input('patient_id');
			$telecom->system = $request->input('system');
			$telecom->value = $request->input('value');
			$telecom->use = $request->input('use');
			$telecom->rank = $request->input('rank');

			try{
				$telecom->save();
				return response()->json($telecom);
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
		$telecom=Telecom::findOrFail($id);
		return response()->json($telecom);
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
			"patient_id" => 'required',
			"system" => 'required',
			"value" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator,422);
		} else {
			$telecom=Telecom::findOrFail($id);
			$telecom->patient_id = $request->input('patient_id');
			$telecom->system = $request->input('system');
			$telecom->value = $request->input('value');
			$telecom->use = $request->input('use');
			$telecom->rank = $request->input('rank');

			try{
				$telecom->save();
				return response()->json($telecom);
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
			$telecom=Telecom::findOrFail($id);
			$telecom->delete();
			return response()->json($telecom,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}