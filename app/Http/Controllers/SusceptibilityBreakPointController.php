<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use Illuminate\Http\Request;
use App\Models\SusceptibilityBreakPoint;

class SusceptibilityBreakPointController extends Controller
{
    public function index()
    {
        $susceptibilityBreakPoint = SusceptibilityBreakPoint::all();

        return response()->json($susceptibilityBreakPoint);
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
            'antibiotic_id' => 'required',
            'measure_range_id' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $susceptibilityBreakPoint = new SusceptibilityBreakPoint;
            $susceptibilityBreakPoint->antibiotic_id = $request->input('antibiotic_id');
            $susceptibilityBreakPoint->measure_range_id = $request->input('measure_range_id');
            $susceptibilityBreakPoint->resistant_max = $request->input('resistant_max');
            $susceptibilityBreakPoint->intermediate_min = $request->input('intermediate_min');
            $susceptibilityBreakPoint->intermediate_max = $request->input('intermediate_max');
            $susceptibilityBreakPoint->sensitive_min = $request->input('sensitive_min');

            try {
                $susceptibilityBreakPoint->save();

                return response()->json($susceptibilityBreakPoint->loader());
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
        $susceptibilityBreakPoint = SusceptibilityBreakPoint::findOrFail($id);

        return response()->json($susceptibilityBreakPoint);
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
            'antibiotic_id' => 'required',
            'measure_range_id' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $susceptibilityBreakPoint = SusceptibilityBreakPoint::findOrFail($id);
            $susceptibilityBreakPoint->antibiotic_id = $request->input('antibiotic_id');
            $susceptibilityBreakPoint->measure_range_id = $request->input('measure_range_id');
            $susceptibilityBreakPoint->resistant_max = $request->input('resistant_max');
            $susceptibilityBreakPoint->intermediate_min = $request->input('intermediate_min');
            $susceptibilityBreakPoint->intermediate_max = $request->input('intermediate_max');
            $susceptibilityBreakPoint->sensitive_min = $request->input('sensitive_min');

            try {
                $susceptibilityBreakPoint->save();

                return response()->json($susceptibilityBreakPoint);
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
            $susceptibilityBreakPoint = SusceptibilityBreakPoint::findOrFail($id);
            $susceptibilityBreakPoint->delete();

            return response()->json($susceptibilityBreakPoint, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
