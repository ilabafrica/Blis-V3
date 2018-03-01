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
use App\Models\CodeableConcept;

class CodeableConceptController extends Controller
{
	public function index()
	{
		$codeableConcept=CodeableConcept::orderBy('id', 'ASC')->paginate(20);
		return response()->json($codeableConcept);
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
			"text" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator);
		} else {
			$codeableConcept= new CodeableConcept;
			$codeableConcept->code = $request->input('code');
			$codeableConcept->text = $request->input('text');

			try{
				$codeableConcept->save();
				return response()->json($codeableConcept);
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
		$codeableConcept=CodeableConcept::findOrFail($id);
		return response()->json($codeableConcept);
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
			"text" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator,422);
		} else {
			$codeableConcept=CodeableConcept::findOrFail($id);
			$codeableConcept->code = $request->input('code');
			$codeableConcept->text = $request->input('text');

			try{
				$codeableConcept->save();
				return response()->json($codeableConcept);
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
			$codeableConcept=CodeableConcept::findOrFail($id);
			$codeableConcept->delete();
			return response()->json($codeableConcept,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}