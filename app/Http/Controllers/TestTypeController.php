<?php
namespace App\Http\Controllers;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Http\Request;
use App\Models\TestType;

class TestTypeController extends Controller
{
	public function index()
	{
		$testType = TestType::orderBy('id', 'ASC')->paginate(20);
		return response()->json($testType);
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
			"name" => 'required',
			"test_type_category_id" => 'required',
		);

		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator);
		} else {
			$testType = new TestType;
			$testType->name = $request->input('name');
			$testType->description = $request->input('description');
			$testType->test_type_category_id = $request->input('test_type_category_id');
			$testType->targetTAT = $request->input('targetTAT');

			try{
				$testType->save();
				return response()->json($testType);
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
		$testType=TestType::findOrFail($id);
		return response()->json($testType);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  request
	 * @param  int  id
	 * @return \Illuminate\Http\Response
	 */	public function update(Request $request, $id)
	{
		$rules = array(
			"name" => 'required',
			"test_type_category_id" => 'required',
		);

		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$testType = TestType::findOrFail($id);
			$testType->name = $request->input('name');
			$testType->description = $request->input('description');
			$testType->test_type_category_id = $request->input('test_type_category_id');
			$testType->targetTAT = $request->input('targetTAT');

			try{
				$testType->save();
				return response()->json($testType);
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
			$testType = TestType::findOrFail($id);
			$testType->delete();
			return response()->json($testType,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}