<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $test = Test::orderBy('id', 'ASC')->paginate(20);

        return response()->json($test);
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
            'encounter_id' => 'required',
            'test_type_id' => 'required',
            'specimen_id' => 'required',
            'test_status_id' => 'required',
            'created_by' => 'required',
            'tested_by' => 'required',
            'verified_by' => 'required',
            'requested_by' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $test = new Test;
            $test->encounter_id = $request->input('encounter_id');
            $test->identifier = $request->input('identifier');
            $test->test_type_id = $request->input('test_type_id');
            $test->specimen_id = $request->input('specimen_id');
            $test->test_status_id = $request->input('test_status_id');
            $test->created_by = $request->input('created_by');
            $test->tested_by = $request->input('tested_by');
            $test->verified_by = $request->input('verified_by');
            $test->requested_by = $request->input('requested_by');
            $test->time_started = $request->input('time_started');
            $test->time_completed = $request->input('time_completed');
            $test->time_verified = $request->input('time_verified');
            $test->time_sent = $request->input('time_sent');

            try {
                $test->save();

                return response()->json($test);
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
        $test = Test::findOrFail($id);

        return response()->json($test);
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
            'encounter_id' => 'required',
            'test_type_id' => 'required',
            'specimen_id' => 'required',
            'test_status_id' => 'required',
            'created_by' => 'required',
            'tested_by' => 'required',
            'verified_by' => 'required',
            'requested_by' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $test = Test::findOrFail($id);
            $test->encounter_id = $request->input('encounter_id');
            $test->identifier = $request->input('identifier');
            $test->test_type_id = $request->input('test_type_id');
            $test->specimen_id = $request->input('specimen_id');
            $test->test_status_id = $request->input('test_status_id');
            $test->created_by = $request->input('created_by');
            $test->tested_by = $request->input('tested_by');
            $test->verified_by = $request->input('verified_by');
            $test->requested_by = $request->input('requested_by');
            $test->time_started = $request->input('time_started');
            $test->time_completed = $request->input('time_completed');
            $test->time_verified = $request->input('time_verified');
            $test->time_sent = $request->input('time_sent');

            try {
                $test->save();

                return response()->json($test);
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
            $test = Test::findOrFail($id);
            $test->delete();

            return response()->json($test, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
