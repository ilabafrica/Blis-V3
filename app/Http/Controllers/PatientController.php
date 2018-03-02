<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patient = Patient::orderBy('id', 'ASC')->paginate(20);

        return response()->json($patient);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'identifier' => 'required',
            'active' => 'required',
            'name_id' => 'required',
            'gender_id' => 'required',
            'birth_date' => 'required',
            'created_by' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $patient = new Patient;
            $patient->identifier = $request->input('identifier');
            $patient->active = $request->input('active');
            $patient->name_id = $request->input('name_id');
            $patient->telecom_id = $request->input('telecom_id');
            $patient->gender_id = $request->input('gender_id');
            $patient->birth_date = $request->input('birth_date');
            $patient->deceased = $request->input('deceased');
            $patient->deceased_date_time = $request->input('deceased_date_time');
            $patient->address_id = $request->input('address_id');
            $patient->marital_status = $request->input('marital_status');
            $patient->photo = $request->input('photo');
            $patient->animal = $request->input('animal');
            $patient->species_id = $request->input('species_id');
            $patient->breed_id = $request->input('breed_id');
            $patient->gender_status = $request->input('gender_status');
            $patient->practitioner_id = $request->input('practitioner_id');
            $patient->organization_id = $request->input('organization_id');
            $patient->created_by = $request->input('created_by');

            try {
                $patient->save();

                return response()->json($patient);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::findOrFail($id);

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
        $rules = [
            'identifier' => 'required',
            'active' => 'required',
            'name_id' => 'required',
            'gender_id' => 'required',
            'birth_date' => 'required',
            'created_by' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $patient = Patient::findOrFail($id);
            $patient->identifier = $request->input('identifier');
            $patient->active = $request->input('active');
            $patient->name_id = $request->input('name_id');
            $patient->telecom_id = $request->input('telecom_id');
            $patient->gender_id = $request->input('gender_id');
            $patient->birth_date = $request->input('birth_date');
            $patient->deceased = $request->input('deceased');
            $patient->deceased_date_time = $request->input('deceased_date_time');
            $patient->address_id = $request->input('address_id');
            $patient->marital_status = $request->input('marital_status');
            $patient->photo = $request->input('photo');
            $patient->animal = $request->input('animal');
            $patient->species_id = $request->input('species_id');
            $patient->breed_id = $request->input('breed_id');
            $patient->gender_status = $request->input('gender_status');
            $patient->practitioner_id = $request->input('practitioner_id');
            $patient->organization_id = $request->input('organization_id');
            $patient->created_by = $request->input('created_by');

            try {
                $patient->save();

                return response()->json($patient);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();

            return response()->json($patient, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
