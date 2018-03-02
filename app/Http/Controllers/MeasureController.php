<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use App\Models\Measure;
use Illuminate\Http\Request;

class MeasureController extends Controller
{
    public function index()
    {
        $measure = Measure::orderBy('id', 'ASC')->paginate(20);

        return response()->json($measure);
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
            'measure_type_id' => 'required',
            'name' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $measure = new Measure;
            $measure->measure_type_id = $request->input('measure_type_id');
            $measure->name = $request->input('name');
            $measure->unit = $request->input('unit');
            $measure->description = $request->input('description');

            try {
                $measure->save();

                return response()->json($measure);
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
        $measure = Measure::findOrFail($id);

        return response()->json($measure);
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
            'measure_type_id' => 'required',
            'name' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $measure = Measure::findOrFail($id);
            $measure->measure_type_id = $request->input('measure_type_id');
            $measure->name = $request->input('name');
            $measure->unit = $request->input('unit');
            $measure->description = $request->input('description');

            try {
                $measure->save();

                return response()->json($measure);
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
            $measure = Measure::findOrFail($id);
            $measure->delete();

            return response()->json($measure, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
