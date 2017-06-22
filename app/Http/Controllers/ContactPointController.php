<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactPoint;

class ContactPointController extends Controller
{
	public function index()
	{
		$contactpoint=ContactPoint::orderBy('id', 'ASC')->paginate(20);
		return response()->json(ContactPoint);
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
		"user_id" => 'required',
		"system" => 'required',
		"value" => 'required',
		"use" => 'required',

		);		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$contactpoint= new ContactPoint;
			$contactpoint->user_id = $request->input('user_id');
			$contactpoint->system = $request->input('system');
			$contactpoint->value = $request->input('value');
			$contactpoint->use = $request->input('use');
			$contactpoint->rank = $request->input('rank');
			$contactpoint->period = $request->input('period');

			try{
				$contactpoint->save();
				return response()->json($contactpoint);
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
		$contactpoint=ContactPoint::findorfails($id);
		return response()->json($contactpoint);
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
		"user_id" => 'required',
		"system" => 'required',
		"value" => 'required',
		"use" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$contactpoint=ContactPoint::findorfail($id);
			$contactpoint->user_id = $request->input('user_id');
			$contactpoint->system = $request->input('system');
			$contactpoint->value = $request->input('value');
			$contactpoint->use = $request->input('use');
			$contactpoint->rank = $request->input('rank');
			$contactpoint->period = $request->input('period');

			try{
				$contactpoint->save();
				return response()->json($contactpoint);
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
			$contactpoint=ContactPoint::findorfails($id);
			$contactpoint->delete();
			return response()->json($contactpoint,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}