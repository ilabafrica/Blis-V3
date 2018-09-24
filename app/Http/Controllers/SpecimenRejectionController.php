<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use Auth;
use App\Models\TestPhase;
use Illuminate\Http\Request;
use App\Models\SpecimenRejection;
use App\Models\RejectionReason;

class SpecimenRejectionController extends Controller
{
    public function index()
    {
        $specimenRejection = SpecimenRejection::orderBy('id', 'ASC')->paginate(10);

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
            'rejection_reason_ids' => 'required',
            'authorized_person_informed' => 'required',
            'specimen_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);

        } else {

            $rejection = new SpecimenRejection;
            $rejection->specimen_id = $request->input('specimen_id');

            // if it is analytic rejection test_id is submitted
            if ($request->input('test_id')) {
                // to reject specimen only for a particular test
                $rejection->test_phase_id = TestPhase::analytical;
                $rejection->test_id = $request->input('test_id');

            } else {

                $rejection->test_phase_id = TestPhase::pre_analytical;
            }
            $rejection->authorized_person_informed = $request->input('authorized_person_informed');
            $rejection->rejected_by = Auth::user()->id;
            $rejection->time_rejected = date('Y-m-d H:i:s');
            $rejection->save();

            foreach ($request->input('rejection_reason_ids') as $rejectionReasonId) {
                $rejectionReason = RejectionReason::find($rejectionReasonId);
                $rejectionReason->specimenRejection()->attach($rejection);
            }
            return response()->json($rejection);
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
            $specimenRejection->authorized_person_informed = $request->input('authorized_person_informed');

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

    public function attachReason(Request $request)
    {
        $rules = [
            'rejection_reason_id' => 'required',
            'specimen_rejection_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);
        } else {

                $specimenRejection = SpecimenRejection::find($request->input('specimen_rejection_id'));
                $rejectionReason = RejectionReason::find($request->input('rejection_reason_id'));
            try {
                $specimenRejection->attach($rejectionReason);

                return response()->json(['message' => 'Item Successfully Created']);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    public function detachReason(Request $request)
    {
        $rules = [
            'rejection_reason_id' => 'required',
            'specimen_rejection_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);
        } else {
            $specimenRejection = SpecimenRejection::find($request->input('specimen_rejection_id'));
            $rejectionReason = RejectionReason::find($request->input('rejection_reason_id'));

            try {
                $specimenRejection->detach($rejectionReason);

                return response()->json(['message' => 'Item Successfully deleted']);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
}
