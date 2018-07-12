<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use App\Models\ControlTest;
use Illuminate\Http\Request;

class ControlTestController extends Controller
{
    public function index()
    {
        $controlTest = ControlTest::orderBy('id', 'ASC')->paginate(20);

        return response()->json($controlTest);
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
            'lot_id' => 'required',
            'tested_by' => 'required',
            'control_id' => 'required',
            'control_type_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $controlTest = new ControlTest;
            $controlTest->lot_id = $request->input('lot_id');
            $controlTest->tested_by = $request->input('tested_by');
            $controlTest->control_id = $request->input('control_id');
            $controlTest->control_type_id = $request->input('control_type_id');

            try {
                $controlTest->save();

                return response()->json($controlTest);
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
        $controlTest = ControlTest::findOrFail($id);

        return response()->json($controlTest);
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
            'lot_id' => 'required',
            'tested_by' => 'required',
            'control_id' => 'required',
            'control_type_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $controlTest = ControlTest::findOrFail($id);
            $controlTest->lot_id = $request->input('lot_id');
            $controlTest->tested_by = $request->input('tested_by');
            $controlTest->control_id = $request->input('control_id');
            $controlTest->control_type_id = $request->input('control_type_id');

            try {
                $controlTest->save();

                return response()->json($controlTest);
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
            $controlTest = ControlTest::findOrFail($id);
            $controlTest->delete();

            return response()->json($controlTest, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
