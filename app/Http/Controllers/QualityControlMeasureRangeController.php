<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Http\Request;
use App\Models\QualityControlMeasureRange;

class QualityControlMeasureRangeController extends Controller
{
    public function index()
    {
        $qualityControlMeasureRange = QualityControlMeasureRange::orderBy('id', 'ASC')->paginate(20);
        return response()->json($qualityControlMeasureRange);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'control_measure_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $qualityControlMeasureRange = new QualityControlMeasureRange;
            $qualityControlMeasureRange->upper_range = $request->input('upper_range');
            $qualityControlMeasureRange->lower_range = $request->input('lower_range');
            $qualityControlMeasureRange->alphanumeric = $request->input('alphanumeric');
            $qualityControlMeasureRange->control_measure_id = $request->input('control_measure_id');

            try {
                $qualityControlMeasureRange->save();
                return response()->json($qualityControlMeasureRange);
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
        $qualityControlMeasureRange = QualityControlMeasureRange::findOrFail($id);
        return response()->json($qualityControlMeasureRange);
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
            'control_measure_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $qualityControlMeasureRange = QualityControlMeasureRange::findOrFail($id);
            $qualityControlMeasureRange->upper_range = $request->input('upper_range');
            $qualityControlMeasureRange->lower_range = $request->input('lower_range');
            $qualityControlMeasureRange->alphanumeric = $request->input('alphanumeric');
            $qualityControlMeasureRange->control_measure_id = $request->input('control_measure_id');

            try {
                $qualityControlMeasureRange->save();
                return response()->json($qualityControlMeasureRange);
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
            $qualityControlMeasureRange = QualityControlMeasureRange::findOrFail($id);
            $qualityControlMeasureRange->delete();
            return response()->json($qualityControlMeasureRange, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}