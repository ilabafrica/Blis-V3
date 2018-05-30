<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Http\Request;
use App\Models\QualityControlTest;

class QualityControlTestController extends Controller
{
    public function index()
    {
        $qualityControlTest = QualityControlTest::orderBy('id', 'ASC')->paginate(20);
        return response()->json($qualityControlTest);
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
            'entered_by' => 'required',
            'control_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $qualityControlTest = new QualityControlTest;
            $qualityControlTest->entered_by = $request->input('entered_by');
            $qualityControlTest->control_id = $request->input('control_id');

            try {
                $qualityControlTest->save();
                return response()->json($qualityControlTest);
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
        $qualityControlTest = QualityControlTest::findOrFail($id);
        return response()->json($qualityControlTest);
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
            'entered_by' => 'required',
            'control_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $qualityControlTest = QualityControlTest::findOrFail($id);
            $qualityControlTest->entered_by = $request->input('entered_by');
            $qualityControlTest->control_id = $request->input('control_id');

            try {
                $qualityControlTest->save();
                return response()->json($qualityControlTest);
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
            $qualityControlTest = QualityControlTest::findOrFail($id);
            $qualityControlTest->delete();
            return response()->json($qualityControlTest, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}