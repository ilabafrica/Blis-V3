<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Http\Request;
use App\Models\QualityControlMeasure;

class QualityControlMeasureController extends Controller
{
    public function index()
    {
        $qualityControlMeasure = QualityControlMeasure::orderBy('id', 'ASC')->paginate(20);
        return response()->json($qualityControlMeasure);
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
            'name' => 'required',
            'unit' => 'required',
            'control_id' => 'required',
            'control_measure_type_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $qualityControlMeasure = new QualityControlMeasure;
            $qualityControlMeasure->name = $request->input('name');
            $qualityControlMeasure->unit = $request->input('unit');
            $qualityControlMeasure->control_id = $request->input('control_id');
            $qualityControlMeasure->control_measure_type_id = $request->input('control_measure_type_id');

            try {
                $qualityControlMeasure->save();
                return response()->json($qualityControlMeasure);
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
        $qualityControlMeasure = QualityControlMeasure::findOrFail($id);
        return response()->json($qualityControlMeasure);
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
            'control_id' => 'required',
            'control_measure_type_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $qualityControlMeasure = QualityControlMeasure::findOrFail($id);
            $qualityControlMeasure->name = $request->input('name');
            $qualityControlMeasure->unit = $request->input('unit');
            $qualityControlMeasure->control_id = $request->input('control_id');
            $qualityControlMeasure->control_measure_type_id = $request->input('control_measure_type_id');

            try {
                $qualityControlMeasure->save();
                return response()->json($qualityControlMeasure);
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
            $qualityControlMeasure = QualityControlMeasure::findOrFail($id);
            $qualityControlMeasure->delete();
            return response()->json($qualityControlMeasure, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}