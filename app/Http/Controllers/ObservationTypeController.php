<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObservationType;

class ObservationTypeController extends Controller
{
	public function index()
	{
		$observationtype = ObservationType::orderBy('id', 'ASC')->paginate(20);
		return response()->json($observationtype);
	}


    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request
    * @return \Illuminate\Http\Response
    */
	public function store(Request $request)
	{
        $rules=array(
		"status_id" => 'required',
		"category_id" => 'required',
		"code_id" => 'required',
		"result_type" => 'required',
		"sort_order" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$observationtype= new ObservationType;
			$observationtype->status_id = $request->input('status_id');
			$observationtype->category_id = $request->input('category_id');
			$observationtype->code_id = $request->input('code_id');
			$observationtype->result_type = $request->input('result_type');
			$observationtype->sort_order = $request->input('sort_order');

			try{
				$observationtype->save();
				return response()->json($observationtype);
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
     */public function show($id){
		$observationtype=ObservationType::findorfail($id);
		return response()->json($observationtype);
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
		"status_id" => 'required',
		"category_id" => 'required',
		"code_id" => 'required',
		"result_type" => 'required',
		"sort_order" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$observationtype=ObservationType::findorfail($id);
			$observationtype->status_id = $request->input('status_id');
			$observationtype->category_id = $request->input('category_id');
			$observationtype->code_id = $request->input('code_id');
			$observationtype->result_type = $request->input('result_type');
			$observationtype->sort_order = $request->input('sort_order');

			try{
				$observationtype->save();
				return response()->json($observationtype);
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
			$observationtype=ObservationType::findorfail($id);
			$observationtype->delete();
			return response()->json($observationtype,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}