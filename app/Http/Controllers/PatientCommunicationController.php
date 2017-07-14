<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientCommunication;

class PatientCommunicationController extends Controller
{
	public function index()
	{
		$patientcommunication = PatientCommunication::orderBy('id', 'ASC')->paginate(20);
		return response()->json($patientcommunication);
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
		"patient_id" => 'required',
		"language" => 'required',
		"preferred" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$patientcommunication= new PatientCommunication;
			$patientcommunication->patient_id = $request->input('patient_id');
			$patientcommunication->language = $request->input('language');
			$patientcommunication->preferred = $request->input('preferred');

			try{
				$patientcommunication->save();
				return response()->json($patientcommunication);
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
		$patientcommunication=PatientCommunication::findorfail($id);
		return response()->json($patientcommunication);
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
		"language" => 'required',
		"preferred" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$patientcommunication=PatientCommunication::findorfail($id);
			$patientcommunication->patient_id = $request->input('patient_id');
			$patientcommunication->language = $request->input('language');
			$patientcommunication->preferred = $request->input('preferred');

			try{
				$patientcommunication->save();
				return response()->json($patientcommunication);
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
			$patientcommunication=PatientCommunication::findorfail($id);
			$patientcommunication->delete();
			return response()->json($patientcommunication,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}