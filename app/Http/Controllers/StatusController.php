<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
	public function index()
	{
		$status=Status::orderBy('id', 'ASC')->paginate(20);
		return response()->json(Status);
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
		"name" => 'required',

		);		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$status= new Status;
			$status->name = $request->input('name');

			try{
				$status->save();
				return response()->json($status);
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
		$status=Status::findorfails($id);
		return response()->json($status);
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
		"name" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$status=Status::findorfail($id);
			$status->name = $request->input('name');

			try{
				$status->save();
				return response()->json($status);
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
			$status=Status::findorfails($id);
			$status->delete();
			return response()->json($status,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}