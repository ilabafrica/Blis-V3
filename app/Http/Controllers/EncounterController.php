<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use App\Models\Encounter;
use Illuminate\Http\Request;

class EncounterController extends Controller
{
    public function index()
    {
        $encounter = Encounter::orderBy('id', 'ASC')->paginate(20);

        return response()->json($encounter);
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
            'patient_id' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $encounter = new Encounter;
            $encounter->identifier = $request->input('identifier');
            $encounter->patient_id = $request->input('patient_id');
            $encounter->location_id = $request->input('location_id');
            $encounter->encounter_class_id = $request->input('encounter_class_id');
            $encounter->encounter_status_id = $request->input('encounter_status_id');
            $encounter->bed_no = $request->input('bed_no');

            try {
                $encounter->save();

                return response()->json($encounter);
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

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $encounter = Encounter::findOrFail($id);
            $encounter->identifier = $request->input('identifier');
            $encounter->patient_id = $request->input('patient_id');
            $encounter->location_id = $request->input('location_id');
            $encounter->encounter_class_id = $request->input('encounter_class_id');
            $encounter->encounter_status_id = $request->input('encounter_status_id');
            $encounter->bed_no = $request->input('bed_no');

            try {
                $encounter->save();

                return response()->json($encounter);
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
}
