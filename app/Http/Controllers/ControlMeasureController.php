<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Http\Request;
use App\Models\ControlMeasure;

class ControlMeasureController extends Controller
{
    public function index()
    {
        $controlMeasure = ControlMeasure::orderBy('id', 'ASC')->paginate(20);
        return response()->json($controlMeasure);
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
            'name' => 'required',
            'unit' => 'required',
            'control_type_id' => 'required',
            'measure_type_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $controlMeasure = new ControlMeasure;
            $controlMeasure->name = $request->input('name');
            $controlMeasure->unit = $request->input('unit');
            $controlMeasure->control_type_id = $request->input('control_type_id');
            $controlMeasure->measure_type_id = $request->input('measure_type_id');

            try {
                $controlMeasure->save();
                return response()->json($controlMeasure);
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
        $controlMeasure = ControlMeasure::findOrFail($id);
        return response()->json($controlMeasure);
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
        $rules = array(
            'name' => 'required',
            'unit' => 'required',
            'control_type_id' => 'required',
            'measure_type_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $controlMeasure = ControlMeasure::findOrFail($id);
            $controlMeasure->name = $request->input('name');
            $controlMeasure->unit = $request->input('unit');
            $controlMeasure->control_type_id = $request->input('control_type_id');
            $controlMeasure->measure_type_id = $request->input('measure_type_id');

            try {
                $controlMeasure->save();
                return response()->json($controlMeasure);
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
            $controlMeasure = ControlMeasure::findOrFail($id);
            $controlMeasure->delete();
            return response()->json($controlMeasure, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}