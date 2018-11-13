<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */
use Auth;
use App\Models\Test;
use App\Models\Specimen;
use App\Models\Encounter;
use App\Models\TestStatus;
use Illuminate\Http\Request;
use App\Models\SpecimenTrackerModel;

class EncounterController extends Controller
{
    public function index(Request $request)
    {
        // Search Conditions
        if (
            $request->query('search') ||
            $request->query('date_from') ||
            $request->query('date_to')
        ) {
            $encounters = Encounter::search(
                $request->query('search'),
                ($request->query('date_from') ? $request->query('date_from') : date('Y-m-d')),
                $request->query('date_to')
            );
        } else {
            $encounters = Encounter::with(
                'patient.name',
                'patient.gender',
                'tests.testType.specimenTypes'
            )->orderBy('created_at', 'DESC')->paginate(10);
        }

        return response()->json($encounters);
    }

    public function store(Request $request)
    {
        $rules = [
            'patient_id' => 'required',
            'location_id'    => 'required',
            'encounter_class_id'  => 'required',
            'practitioner_name'  => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $encounter = new Encounter;
            $encounter->patient_id = $request->input('patient_id');
            $encounter->location_id = $request->input('location_id');
            $encounter->practitioner_name = $request->input('practitioner_name');
            $encounter->encounter_class_id = $request->input('encounter_class_id');
            $encounter->bed_no = $request->input('bed_no');

            try {
                $encounter->save();

                return response()->json($encounter->loader(), 200);
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
        $encounter = Encounter::findOrFail($id);

        return response()->json($encounter);
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
            'patient_id' => 'required',
            'location_id'    => 'required',
            'encounter_class_id'  => 'required',
            'practitioner_name'  => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $encounter = Encounter::find($id);
            $encounter->patient_id = $request->input('patient_id');
            $encounter->location_id = $request->input('location_id');
            $encounter->practitioner_name = $request->input('practitioner_name');
            $encounter->encounter_class_id = $request->input('encounter_class_id');
            $encounter->bed_no = $request->input('bed_no');

            try {
                $encounter->save();

                return response()->json($encounter->loader(), 200);
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
            $encounter = Encounter::findOrFail($id);
            $encounter->delete();

            return response()->json($encounter, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function specimenCollection(Request $request)
    {
        $rules = [
            //'encounter_id' => 'required',
            'specimen_type_id' => 'required',
            'collected_by' => 'required',
            'time_collected' => 'required',
            'time_received' => 'required',
            //'testIds' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $specimen = new Specimen;
            $specimen->identifier = $request->input('identifier');
            $specimen->accession_identifier = $request->input('accession_identifier');
            $specimen->specimen_type_id = $request->input('specimen_type_id');
            $specimen->parent_id = $request->input('parent_id');
            $specimen->received_by = Auth::user()->id;
            $specimen->collected_by = $request->input('collected_by');
            $specimen->time_collected = $request->input('time_collected');
            $specimen->time_received = $request->input('time_received');
          

            foreach ($request->input('testIds') as $id) {
                $test = Test::find($id);
                $test->specimen_id = $specimen->id;
                $test->encounter_id = $request->input('encounter_id');
                $test->save();
            }

            try {
              
                $specimen->save();

                $count = Specimen::count() + 1;
                $tracker =date('Y_m_d');

                $data = 'ILAB_'.$count. '_'.$tracker;

                $specimentracker = new SpecimenTrackerModel;
                $specimentracker->specimens_id = $data;

                    try{
                        $specimentracker->save();
                    }catch (\Illuminate\Database\QueryException $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                    }
             
                $encounter = Encounter::find($request->input('encounter_id'));

                return response()->json($encounter->loader(), 200);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    public function addTests(Request $request)
    {
        $rules = [
            'encounter_id' => 'required',
            'practitioner_name'  => 'required',
            'testTypeIds' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            foreach ($request->input('testTypeIds') as $testTypeId) {
                // save order items in tests
                $test = new Test;
                $test->encounter_id = $request->input('encounter_id');
                $test->test_type_id = $testTypeId;
                $test->test_status_id = TestStatus::pending;
                $test->created_by = Auth::user()->id;
                $test->requested_by = $request->input('practitioner_name');
                $test->save();
            }

            try {
                $encounter = Encounter::find($request->input('encounter_id'));

                return response()->json($encounter->loader(), 200);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
}
