<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $search = Input::get('search');
        
        $patients = Patient::orderBy('id', 'desc')->paginate();

        return response()->json($patients);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $rules = array(
            
            'name'       => 'required',
            'gender' => 'required',
            'birth_date'=>'required'
        );
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json($validator);
            
        } 
        else {    
            $patient = new Patient;
            $patient->name = $request->input('name');
            $patient->user_id = $request->input('user_id');
            $patient->gender = $request->input('gender');  
            $patient->birth_date = $request->input('birth_date');
            $patient->address = $request->input('address');
            $patient->deceased = $request->input('deceased');
            $patient->marital_status = $request->input('marital_status');
            $patient->multiple_birth = $request->input('multiple_birth');
            $patient->photo = $request->input('photo');
            $patient->general_practitioner_type = $request->input('general_practitioner_type');
            $patient->practitioner_id = $request->input('practitioner_id');
            $patient->organization_id = $request->input('organization_id');
            $patient->save();

        
            return response()->json($patient);
        }
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);

        return response()->json($patient);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'name'       => 'required',
            'gender' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json();
           
        } else {
            // Update
            $patient = Patient::find($id);
            $patient->name = $request->input('name');
            $patient->user_id = $request->input('user_id');
            $patient->gender = $request->input('gender');  
            $patient->birth_date = $request->input('birth_date');
            $patient->address = $request->input('address');
            $patient->deceased = $request->input('deceased');
            $patient->marital_status = $request->input('marital_status');
            $patient->multiple_birth = $request->input('multiple_birth');
            $patient->photo = $request->input('photo');
            $patient->general_practitioner_type = $request->input('general_practitioner_type');
            $patient->practitioner_id = $request->input('practitioner_id');
            $patient->organization_id = $request->input('organization_id');
            $patient->save();

            return response()->json();
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);
        $patient->delete();

        return response()->json();

    }
}
