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
            'gender' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {

            return response()->json();
            
        } 
        else {    
            $patient = new Patient;
            $patient->name = Input::get('name');
            $patient->gender = Input::get('gender');  
            $patient->birth_date = Input::get('birth_date');
            $patient->address = Input::get('address');
            $patient->save();

        return response()->json();

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
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {

            return response()->json();
           
        } else {
            // Update
            $patient = Patient::find($id);
            $patient->name = Input::get('name');
            $patient->gender = Input::get('gender');
            $patient->birth_date = Input::get('birth_date');
            $patient->address = Input::get('address');
            $patient->phone_number = Input::get('phone_number');
            $patient->save();

            // redirect
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
