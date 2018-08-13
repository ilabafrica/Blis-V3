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
use App\Models\AntibioticSusceptibility;

class AntibioticSusceptibilityController extends Controller
{
    public function index()
    {
        $antibioticSusceptibility = AntibioticSusceptibility::orderBy('id', 'ASC')->paginate(10);

        return response()->json($antibioticSusceptibility);
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
            'user_id' => 'required',
            'antibiotic_id' => 'required',
            'result_id' => 'required',
            'susceptibility_range_id' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);
        } else {
            $antibioticSusceptibility = new AntibioticSusceptibility;
            $antibioticSusceptibility->user_id = $request->input('user_id');
            $antibioticSusceptibility->antibiotic_id = $request->input('antibiotic_id');
            $antibioticSusceptibility->result_id = $request->input('result_id');
            $antibioticSusceptibility->susceptibility_range_id = $request->input('susceptibility_range_id');
            $antibioticSusceptibility->zone_diameter = $request->input('zone_diameter');

            try {
                $antibioticSusceptibility->save();

                return response()->json($antibioticSusceptibility);
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
        $antibioticSusceptibility = AntibioticSusceptibility::findOrFail($id);

        return response()->json($antibioticSusceptibility);
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
            'user_id' => 'required',
            'antibiotic_id' => 'required',
            'result_id' => 'required',
            'susceptibility_range_id' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $antibioticSusceptibility = AntibioticSusceptibility::findOrFail($id);
            $antibioticSusceptibility->user_id = $request->input('user_id');
            $antibioticSusceptibility->antibiotic_id = $request->input('antibiotic_id');
            $antibioticSusceptibility->result_id = $request->input('result_id');
            $antibioticSusceptibility->susceptibility_range_id = $request->input('susceptibility_range_id');
            $antibioticSusceptibility->zone_diameter = $request->input('zone_diameter');

            try {
                $antibioticSusceptibility->save();

                return response()->json($antibioticSusceptibility);
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
            $antibioticSusceptibility = AntibioticSusceptibility::findOrFail($id);
            $antibioticSusceptibility->delete();

            return response()->json($antibioticSusceptibility, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
