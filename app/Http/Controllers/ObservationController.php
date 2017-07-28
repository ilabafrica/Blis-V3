<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Observation;

class ObservationController extends Controller
{
	public function index()
	{
		$observation = Observation::orderBy('id', 'ASC')->paginate(20);
		return response()->json($observation);
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
		"panel_id" => 'required',
		"observation_type_id"=>'required',
		"created_by" => 'required',
		"quantity_id" => 'required',
		"data_absent_reason" => 'required',
		"interpretation" => 'required',
		"comment" => 'required',
		"issued" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$observation= new Observation;
			$observation->status_id = $request->input('status_id');
			$observation->category_id = $request->input('category_id');
			$observation->panel_id = $request->input('panel_id');
			$observation->observation_type_id = $request->input('observation_type_id');
			$observation->created_by = $request->input('created_by');
			$observation->quantity_id = $request->input('quantity_id');
			$observation->data_absent_reason = $request->input('data_absent_reason');
			$observation->interpretation = $request->input('interpretation');
			$observation->comment = $request->input('comment');
			$observation->issued = $request->input('issued');

			try{
				$observation->save();
				return response()->json($observation);
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
    	try {
		$observation=Observation::findorfail($id);
		return response()->json($observation);
	}
	catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return response()->json( ['error' => 'Record not found' ], 404);
		}
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
		"panel_id" => 'required',
		"observation_type_id"=>'required',
		"created_by" => 'required',
		"quantity_id" => 'required',
		"data_absent_reason" => 'required',
		"interpretation" => 'required',
		"comment" => 'required',
		"issued" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$observation=Observation::findorfail($id);
			$observation->status_id = $request->input('status_id');
			$observation->category_id = $request->input('category_id');
			$observation->panel_id = $request->input('panel_id');
			$observation->observation_type_id = $request->input('observation_type_id');
			$observation->created_by = $request->input('created_by');
			$observation->quantity_id = $request->input('quantity_id');
			$observation->data_absent_reason = $request->input('data_absent_reason');
			$observation->interpretation = $request->input('interpretation');
			$observation->comment = $request->input('comment');
			$observation->issued = $request->input('issued');

			try{
				$observation->save();
				return response()->json($observation);
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
			$observation=Observation::findorfail($id);
			$observation->delete();
			return response()->json($observation,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
		catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return response()->json( ['error' => 'Record not found' ], 404);
		}
	}
}