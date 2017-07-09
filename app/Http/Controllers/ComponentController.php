<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Component;

class ComponentController extends Controller
{
	public function index()
	{
		$component = Component::orderBy('id', 'ASC')->paginate(20);
		return response()->json($component);
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
		"observation_id" => 'required',
		"performed_by" => 'required',
		"result" => 'required',
		"data_absent_reason" => 'required',
		"interpretation" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$component= new Component;
			$component->observation_id = $request->input('observation_id');
			$component->performed_by = $request->input('performed_by');
			$component->result = $request->input('result');
			$component->data_absent_reason = $request->input('data_absent_reason');
			$component->interpretation = $request->input('interpretation');

			try{
				$component->save();
				return response()->json($component);
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
		$component=Component::findorfails($id);
		return response()->json($component);
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
		"observation_id" => 'required',
		"performed_by" => 'required',
		"result" => 'required',
		"data_absent_reason" => 'required',
		"interpretation" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$component=Component::findorfail($id);
			$component->observation_id = $request->input('observation_id');
			$component->performed_by = $request->input('performed_by');
			$component->result = $request->input('result');
			$component->data_absent_reason = $request->input('data_absent_reason');
			$component->interpretation = $request->input('interpretation');

			try{
				$component->save();
				return response()->json($component);
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
			$component=Component::findorfails($id);
			$component->delete();
			return response()->json($component,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}