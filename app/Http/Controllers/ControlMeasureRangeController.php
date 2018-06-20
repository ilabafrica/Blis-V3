<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Http\Request;
use App\Models\ControlMeasureRange;

class ControlMeasureRangeController extends Controller
{
    public function index()
    {
        $controlMeasureRange = ControlMeasureRange::orderBy('id', 'ASC')->paginate(20);

        return response()->json($controlMeasureRange);
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
            'control_measure_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $controlMeasureRange = new ControlMeasureRange;
            $controlMeasureRange->upper_range = $request->input('upper_range');
            $controlMeasureRange->lower_range = $request->input('lower_range');
            $controlMeasureRange->alphanumeric = $request->input('alphanumeric');
            $controlMeasureRange->control_measure_id = $request->input('control_measure_id');

            try {
                $controlMeasureRange->save();

                return response()->json($controlMeasureRange);
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
        $controlMeasureRange = ControlMeasureRange::findOrFail($id);

        return response()->json($controlMeasureRange);
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
            'control_measure_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $controlMeasureRange = ControlMeasureRange::findOrFail($id);
            $controlMeasureRange->upper_range = $request->input('upper_range');
            $controlMeasureRange->lower_range = $request->input('lower_range');
            $controlMeasureRange->alphanumeric = $request->input('alphanumeric');
            $controlMeasureRange->control_measure_id = $request->input('control_measure_id');

            try {
                $controlMeasureRange->save();

                return response()->json($controlMeasureRange);
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
            $controlMeasureRange = ControlMeasureRange::findOrFail($id);
            $controlMeasureRange->delete();

            return response()->json($controlMeasureRange, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
