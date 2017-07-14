<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusHistory;

class StatusHistoryController extends Controller
{
	public function index()
	{
		$statushistory=StatusHistory::orderBy('id', 'ASC')->paginate(20);
		return response()->json(StatusHistory);
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
		"code" => 'required',
		"episode_of_care_id" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$statushistory= new StatusHistory;
			$statushistory->code = $request->input('code');
			$statushistory->episode_of_care_id = $request->input('episode_of_care_id');

			try{
				$statushistory->save();
				return response()->json($statushistory);
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
		$statushistory=StatusHistory::findorfails($id);
		return response()->json($statushistory);
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
		"episode_of_care_id" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$statushistory=StatusHistory::findorfail($id);
			$statushistory->code = $request->input('code');
			$statushistory->episode_of_care_id = $request->input('episode_of_care_id');

			try{
				$statushistory->save();
				return response()->json($statushistory);
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
			$statushistory=StatusHistory::findorfails($id);
			$statushistory->delete();
			return response()->json($statushistory,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}