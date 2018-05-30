<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Http\Request;
use App\Models\QualityControlResult;

class QualityControlResultController extends Controller
{
    public function index()
    {
        $qualityControlResult = QualityControlResult::orderBy('id', 'ASC')->paginate(20);
        return response()->json($qualityControlResult);
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
            'results' => 'required',
            'control_measure_id' => 'required',
            'control_test_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $qualityControlResult = new QualityControlResult;
            $qualityControlResult->results = $request->input('results');
            $qualityControlResult->control_measure_id = $request->input('control_measure_id');
            $qualityControlResult->control_test_id = $request->input('control_test_id');

            try {
                $qualityControlResult->save();
                return response()->json($qualityControlResult);
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
        $qualityControlResult = QualityControlResult::findOrFail($id);
        return response()->json($qualityControlResult);
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
            'results' => 'required',
            'control_measure_id' => 'required',
            'control_test_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $qualityControlResult = QualityControlResult::findOrFail($id);
            $qualityControlResult->results = $request->input('results');
            $qualityControlResult->control_measure_id = $request->input('control_measure_id');
            $qualityControlResult->control_test_id = $request->input('control_test_id');

            try {
                $qualityControlResult->save();
                return response()->json($qualityControlResult);
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
            $qualityControlResult = QualityControlResult::findOrFail($id);
            $qualityControlResult->delete();
            return response()->json($qualityControlResult, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}