<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PractitionerQualification;

class PractitionerQualificationController extends Controller
{
	public function index()
	{
		$practitionerqualification = PractitionerQualification::orderBy('id', 'ASC')->paginate(20);
		return response()->json($practitionerqualification);
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
		"name" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$practitionerqualification= new PractitionerQualification;
			$practitionerqualification->practitioner_id = $request->input('practitioner_id');
			$practitionerqualification->name = $request->input('name');
			$practitionerqualification->period = $request->input('period');
			$practitionerqualification->issuer = $request->input('issuer');

			try{
				$practitionerqualification->save();
				return response()->json($practitionerqualification);
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
    	try{
		$practitionerqualification=PractitionerQualification::findorfail($id);
		return response()->json($practitionerqualification);
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
		"practitioner_id" => 'required',
		"name" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$practitionerqualification=PractitionerQualification::findorfail($id);
			$practitionerqualification->practitioner_id = $request->input('practitioner_id');
			$practitionerqualification->name = $request->input('name');
			$practitionerqualification->period = $request->input('period');
			$practitionerqualification->issuer = $request->input('issuer');

			try{
				$practitionerqualification->save();
				return response()->json($practitionerqualification);
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
			$practitionerqualification=PractitionerQualification::findorfail($id);
			$practitionerqualification->delete();
			return response()->json($practitionerqualification,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
		catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return response()->json( ['error' => 'Record not found' ], 404);
		}
	}
}