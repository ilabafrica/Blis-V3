<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use App\Models\MeasureRange;
use Illuminate\Http\Request;

class MeasureRangeController extends Controller
{
    public function index()
    {
        $measureRange = MeasureRange::orderBy('id', 'ASC')->paginate(20);

        return response()->json($measureRange);
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
            'measure_id' => 'required',
            'gender_id' => 'required',
            'display' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $measureRange = new MeasureRange;
            $measureRange->code = $request->input('code');
            $measureRange->code_id = $request->input('code_id');
            $measureRange->system = $request->input('system');
            $measureRange->measure_id = $request->input('measure_id');
            $measureRange->age_min = $request->input('age_min');
            $measureRange->age_max = $request->input('age_max');
            $measureRange->gender_id = $request->input('gender_id');
            $measureRange->low = $request->input('low');
            $measureRange->high = $request->input('high');
            $measureRange->low_critical = $request->input('low_critical');
            $measureRange->high_critical = $request->input('high_critical');
            $measureRange->display = $request->input('display');
            $measureRange->interpretation_id = $request->input('interpretation_id');

            try {
                $measureRange->save();

                return response()->json($measureRange);
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
        $measureRange = MeasureRange::findOrFail($id);

        return response()->json($measureRange);
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
            'measure_id' => 'required',
            'gender_id' => 'required',
            'display' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $measureRange = MeasureRange::findOrFail($id);
            $measureRange->code = $request->input('code');
            $measureRange->code_id = $request->input('code_id');
            $measureRange->system = $request->input('system');
            $measureRange->measure_id = $request->input('measure_id');
            $measureRange->age_min = $request->input('age_min');
            $measureRange->age_max = $request->input('age_max');
            $measureRange->gender_id = $request->input('gender_id');
            $measureRange->low = $request->input('low');
            $measureRange->high = $request->input('high');
            $measureRange->low_critical = $request->input('low_critical');
            $measureRange->high_critical = $request->input('high_critical');
            $measureRange->display = $request->input('display');
            $measureRange->interpretation_id = $request->input('interpretation_id');

            try {
                $measureRange->save();

                return response()->json($measureRange);
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
            $measureRange = MeasureRange::findOrFail($id);
            $measureRange->delete();

            return response()->json($measureRange, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
