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
use App\Models\SpecimenRejection;

class SpecimenRejectionController extends Controller
{
    public function index()
    {
        $specimenRejection = SpecimenRejection::orderBy('id', 'ASC')->paginate(20);

        return response()->json($specimenRejection);
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
            'test_id' => 'required',
            'specimen_id' => 'required',
            'test_phase_id' => 'required',
            'rejected_by' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $specimenRejection = new SpecimenRejection;
            $specimenRejection->test_id = $request->input('test_id');
            $specimenRejection->specimen_id = $request->input('specimen_id');
            $specimenRejection->test_phase_id = $request->input('test_phase_id');
            $specimenRejection->rejected_by = $request->input('rejected_by');
            $specimenRejection->rejection_reason_id = $request->input('rejection_reason_id');
            $specimenRejection->reject_explained_to = $request->input('reject_explained_to');
            $specimenRejection->time_rejected = $request->input('time_rejected');

            try {
                $specimenRejection->save();

                return response()->json($specimenRejection);
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
        $specimenRejection = SpecimenRejection::findOrFail($id);

        return response()->json($specimenRejection);
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
            'test_id' => 'required',
            'specimen_id' => 'required',
            'test_phase_id' => 'required',
            'rejected_by' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $specimenRejection = SpecimenRejection::findOrFail($id);
            $specimenRejection->test_id = $request->input('test_id');
            $specimenRejection->specimen_id = $request->input('specimen_id');
            $specimenRejection->test_phase_id = $request->input('test_phase_id');
            $specimenRejection->rejected_by = $request->input('rejected_by');
            $specimenRejection->rejection_reason_id = $request->input('rejection_reason_id');
            $specimenRejection->reject_explained_to = $request->input('reject_explained_to');
            $specimenRejection->time_rejected = $request->input('time_rejected');

            try {
                $specimenRejection->save();

                return response()->json($specimenRejection);
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
            $specimenRejection = SpecimenRejection::findOrFail($id);
            $specimenRejection->delete();

            return response()->json($specimenRejection, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
