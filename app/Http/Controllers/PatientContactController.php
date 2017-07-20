<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientContact;

class PatientContactController extends Controller
{
	public function index()
	{
		$patientcontact = PatientContact::orderBy('id', 'ASC')->paginate(20);
		return response()->json($patientcontact);
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
		"relationship" => 'required',
		"name" => 'required',
		"telecom" => 'required',
		"gender" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$patientcontact= new PatientContact;
			$patientcontact->patient_id = $request->input('patient_id');
			$patientcontact->relationship = $request->input('relationship');
			$patientcontact->name = $request->input('name');
			$patientcontact->telecom = $request->input('telecom');
			$patientcontact->address = $request->input('address');
			$patientcontact->gender = $request->input('gender');
			$patientcontact->organization_id = $request->input('organization_id');
			$patientcontact->period = $request->input('period');

			try{
				$patientcontact->save();
				return response()->json($patientcontact);
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
		$patientcontact=PatientContact::findorfail($id);
		return response()->json($patientcontact);
	} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
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
		"patient_id" => 'required',
		"relationship" => 'required',
		"name" => 'required',
		"telecom" => 'required',
		"gender" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$patientcontact=PatientContact::findorfail($id);
			$patientcontact->patient_id = $request->input('patient_id');
			$patientcontact->relationship = $request->input('relationship');
			$patientcontact->name = $request->input('name');
			$patientcontact->telecom = $request->input('telecom');
			$patientcontact->address = $request->input('address');
			$patientcontact->gender = $request->input('gender');
			$patientcontact->organization_id = $request->input('organization_id');
			$patientcontact->period = $request->input('period');

			try{
				$patientcontact->save();
				return response()->json($patientcontact);
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
			$patientcontact=PatientContact::findorfail($id);
			$patientcontact->delete();
			return response()->json($patientcontact,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return response()->json( ['error' => 'Record not found' ], 404);
		}
	}
}