<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PractitionerCommunication;

class PractitionerCommunicationController extends Controller
{
	public function index()
	{
		$practitionercommunication = PractitionerCommunication::orderBy('id', 'ASC')->paginate(20);
		return response()->json($practitionercommunication);
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
		"practitioner_id" => 'required',
		"patient_id" => 'required',
		"language" => 'required',
		"preferred" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$practitionercommunication= new PractitionerCommunication;
			$practitionercommunication->practitioner_id = $request->input('practitioner_id');
			$practitionercommunication->patient_id = $request->input('patient_id');
			$practitionercommunication->language = $request->input('language');
			$practitionercommunication->preferred = $request->input('preferred');

			try{
				$practitionercommunication->save();
				return response()->json($practitionercommunication);
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
		$practitionercommunication=PractitionerCommunication::findorfails($id);
		return response()->json($practitionercommunication);
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
		"practitioner_id" => 'required',
		"patient_id" => 'required',
		"language" => 'required',
		"preferred" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$practitionercommunication=PractitionerCommunication::findorfail($id);
			$practitionercommunication->practitioner_id = $request->input('practitioner_id');
			$practitionercommunication->patient_id = $request->input('patient_id');
			$practitionercommunication->language = $request->input('language');
			$practitionercommunication->preferred = $request->input('preferred');

			try{
				$practitionercommunication->save();
				return response()->json($practitionercommunication);
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
			$practitionercommunication=PractitionerCommunication::findorfails($id);
			$practitionercommunication->delete();
			return response()->json($practitionercommunication,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}