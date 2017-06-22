<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
	public function index()
	{
		$patient=Patient::orderBy('id', 'ASC')->paginate(20);
		return response()->json(Patient);
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
		"active" => 'required',
		"name" => 'required',
		"gender" => 'required',
		"birth_date" => 'required',
		"deceased" => 'required',
		"address" => 'required',
		"marital_status" => 'required',
		"multiple_birth" => 'required',
		"animal" => 'required',

		);		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$patient= new Patient;
			$patient->user_id = $request->input('user_id');
			$patient->active = $request->input('active');
			$patient->name = $request->input('name');
			$patient->gender = $request->input('gender');
			$patient->birth_date = $request->input('birth_date');
			$patient->deceased = $request->input('deceased');
			$patient->address = $request->input('address');
			$patient->marital_status = $request->input('marital_status');
			$patient->multiple_birth = $request->input('multiple_birth');
			$patient->photo = $request->input('photo');
			$patient->animal = $request->input('animal');
			$patient->animal_species = $request->input('animal_species');
			$patient->animal_breed = $request->input('animal_breed');
			$patient->animal_gender_status = $request->input('animal_gender_status');
			$patient->general_practitioner_type = $request->input('general_practitioner_type');
			$patient->general_practitioner_id = $request->input('general_practitioner_id');
			$patient->managing_organization = $request->input('managing_organization');

			try{
				$patient->save();
				return response()->json($patient);
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
		$patient=Patient::findorfails($id);
		return response()->json($patient);
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
		"active" => 'required',
		"name" => 'required',
		"gender" => 'required',
		"birth_date" => 'required',
		"deceased" => 'required',
		"address" => 'required',
		"marital_status" => 'required',
		"multiple_birth" => 'required',
		"animal" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$patient=Patient::findorfail($id);
			$patient->user_id = $request->input('user_id');
			$patient->active = $request->input('active');
			$patient->name = $request->input('name');
			$patient->gender = $request->input('gender');
			$patient->birth_date = $request->input('birth_date');
			$patient->deceased = $request->input('deceased');
			$patient->address = $request->input('address');
			$patient->marital_status = $request->input('marital_status');
			$patient->multiple_birth = $request->input('multiple_birth');
			$patient->photo = $request->input('photo');
			$patient->animal = $request->input('animal');
			$patient->animal_species = $request->input('animal_species');
			$patient->animal_breed = $request->input('animal_breed');
			$patient->animal_gender_status = $request->input('animal_gender_status');
			$patient->general_practitioner_type = $request->input('general_practitioner_type');
			$patient->general_practitioner_id = $request->input('general_practitioner_id');
			$patient->managing_organization = $request->input('managing_organization');

			try{
				$patient->save();
				return response()->json($patient);
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
			$patient=Patient::findorfails($id);
			$patient->delete();
			return response()->json($patient,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}