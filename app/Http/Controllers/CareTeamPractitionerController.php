<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CareTeamPractitioner;

class CareTeamPractitionerController extends Controller
{
	public function index()
	{
		$careteampractitioner = CareTeamPractitioner::orderBy('id', 'ASC')->paginate(20);
		return response()->json($careteampractitioner);
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
		"team_id" => 'required',
		"practioner_id" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$careteampractitioner= new CareTeamPractitioner;
			$careteampractitioner->team_id = $request->input('team_id');
			$careteampractitioner->practioner_id = $request->input('practioner_id');

			try{
				$careteampractitioner->save();
				return response()->json($careteampractitioner);
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
		$careteampractitioner=CareTeamPractitioner::findorfails($id);
		return response()->json($careteampractitioner);
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
		"team_id" => 'required',
		"practioner_id" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$careteampractitioner=CareTeamPractitioner::findorfail($id);
			$careteampractitioner->team_id = $request->input('team_id');
			$careteampractitioner->practioner_id = $request->input('practioner_id');

			try{
				$careteampractitioner->save();
				return response()->json($careteampractitioner);
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
			$careteampractitioner=CareTeamPractitioner::findorfails($id);
			$careteampractitioner->delete();
			return response()->json($careteampractitioner,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}