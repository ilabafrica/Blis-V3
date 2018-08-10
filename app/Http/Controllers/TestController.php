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
use EMR;
use App\Models\Test;
use App\Models\Specimen;
use App\Models\Referral;
use App\Models\TestPhase;
use App\Models\TestStatus;
use Illuminate\Http\Request;
use App\Models\ReferralReason;
use App\Models\RejectionReason;
use App\Models\SpecimenRejection;

class TestController extends Controller
{
    public function index(Request $request)
    {
        // Search Conditions
        if(
            $request->query('search')||
            $request->query('test_status_id')||
            $request->query('date_from')||
            $request->query('date_to')
        ){

            $tests = Test::search(
                $request->query('search'),
                $request->query('test_status_id'),
                ($request->query('date_from') ? $request->query('date_from') : date('Y-m-d')),
                $request->query('date_to')
            );

        } else {
            $tests = Test::with(
                'encounter',
                'testStatus',
                'specimen.specimenType',
                'testType.specimenTypes',
                'encounter.patient.name',
                'encounter.patient.gender',
                'testType.measures.measureType',
                'testType.measures.measureRanges',
                'testType.measures.results',
                'results.measure.measureType',
                'results.measure.measureRanges'
            )->orderBy('created_at', 'DESC')->paginate(10);
        }

        return response()->json($tests);
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
            'encounter_id' => 'required',
            'test_type_id' => 'required',
            'specimen_id' => 'required',
            'test_status_id' => 'required',
            'created_by' => 'required',
            'tested_by' => 'required',
            'verified_by' => 'required',
            'requested_by' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);
        } else {
            $test = new Test;
            $test->encounter_id = $request->input('encounter_id');
            $test->identifier = $request->input('identifier');
            $test->test_type_id = $request->input('test_type_id');
            $test->specimen_id = $request->input('specimen_id');
            $test->test_status_id = $request->input('test_status_id');
            $test->created_by = $request->input('created_by');
            $test->tested_by = $request->input('tested_by');
            $test->verified_by = $request->input('verified_by');
            $test->requested_by = $request->input('requested_by');
            $test->time_started = $request->input('time_started');
            $test->time_completed = $request->input('time_completed');
            $test->time_verified = $request->input('time_verified');
            $test->time_sent = $request->input('time_sent');

            try {
                $test->save();

                return response()->json(
                    Test::find($test->id)->load(
                        'testStatus',
                        'specimen.specimenType',
                        'testType.specimenTypes',
                        'testType.measures.measureType',
                        'testType.measures.measureRanges',
                        'testType.measures.results',
                        'results.measure.measureType',
                        'results.measure.measureRanges'
                    ));
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
        $test = Test::find($id)->load(
            'testStatus',
            'specimen.specimenType',
            'testType.specimenTypes',
            'testType.testTypeCategory',
            'testType.measures.measureType',
            'testType.measures.results',
            'results.measure.measureType',
            'results.measure.measureRanges',
            'testType.measures.measureRanges.gender'
        );
        return response()->json($test);
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
            'encounter_id' => 'required',
            'test_type_id' => 'required',
            'specimen_id' => 'required',
            'test_status_id' => 'required',
            'created_by' => 'required',
            'tested_by' => 'required',
            'verified_by' => 'required',
            'requested_by' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $test = Test::find($id);
            $test->encounter_id = $request->input('encounter_id');
            $test->identifier = $request->input('identifier');
            $test->test_type_id = $request->input('test_type_id');
            $test->specimen_id = $request->input('specimen_id');
            $test->test_status_id = $request->input('test_status_id');
            $test->created_by = $request->input('created_by');
            $test->tested_by = $request->input('tested_by');
            $test->verified_by = $request->input('verified_by');
            $test->requested_by = $request->input('requested_by');
            $test->time_started = $request->input('time_started');
            $test->time_completed = $request->input('time_completed');
            $test->time_verified = $request->input('time_verified');
            $test->time_sent = $request->input('time_sent');

            try {
                $test->save();

                return response()->json(
                    Test::find($test->id)->load(
                        'testStatus',
                        'specimen.specimenType',
                        'testType.specimenTypes',
                        'testType.measures.measureType',
                        'testType.measures.measureRanges',
                        'testType.measures.results',
                        'results.measure.measureType',
                        'results.measure.measureRanges'
                    ));

            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    public function specimenCollection(Request $request)
    {
        $rules = [
            'test_id' => 'required',
            'specimen_type_id' => 'required',
            'collected_by' => 'required',
            'time_collected' => 'required',
            'time_received' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);
        } else {
            $specimen = new Specimen;
            $specimen->identifier = $request->input('identifier');
            $specimen->accession_identifier = $request->input('accession_identifier');
            $specimen->specimen_type_id = $request->input('specimen_type_id');
            $specimen->parent_id = $request->input('parent_id');
            $specimen->received_by = Auth::user()->id;
            $specimen->collected_by = $request->input('collected_by');
            $specimen->time_collected = $request->input('time_collected');
            $specimen->time_received = $request->input('time_received');

            $test = Test::find($request->input('test_id'));
            $test->specimen_id = $specimen->id;
            $test->save();

            try {
                $specimen->save();

                return response()->json(
                    Test::find($test->id)->load(
                        'testStatus',
                        'specimen.specimenType',
                        'testType.specimenTypes',
                        'testType.measures.measureType',
                        'testType.measures.measureRanges',
                        'testType.measures.results',
                        'results.measure.measureType',
                        'results.measure.measureRanges'
                    ));

            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    public function specimenRejection(Request $request)
    {
        $rules = [
            'test_id' => 'required',
            'specimen_id' => 'required',
            'rejectionReasonIds' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);
        } else {
            $specimenRejection = new SpecimenRejection;
            $specimenRejection->specimen_id = $request->input('specimen_id');
            $specimenRejection->test_phase_id = TestPhase::analytical;
            $specimenRejection->test_id = $request->input('test_id');
            $specimenRejection->rejected_by = Auth::user()->id;
            $specimenRejection->time_rejected = date('Y-m-d H:i:s');


            try {
                $specimenRejection->save();

                foreach ($request->input('rejectionReasonIds') as $rejectionReasonId) {
                    RejectionReason::find($rejectionReasonId)
                        ->specimenRejection()
                        ->attach($specimenRejection);
                }

                return response()->json(
                    Test::find($request->input('test_id'))->load(
                        'testStatus',
                        'specimen.specimenType',
                        'testType.specimenTypes',
                        'testType.measures.measureType',
                        'testType.measures.measureRanges',
                        'testType.measures.results',
                        'results.measure.measureType',
                        'results.measure.measureRanges'
                    ));

            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    public function specimenReferral(Request $request)
    {
        $rules = [
            'test_id' => 'required',
            'specimen_id' => 'required',
            'referred_to' => 'required',
            'time_dispatched_to' => 'required',
            'referralReasonIds' => 'required',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);
        } else {
            $referral = new Referral;
            $referral->specimen_id = $request->input('specimen_id');
            $referral->user_id = Auth::user()->id;
            $referral->referred_to = $request->input('referred_to');
            $referral->time_dispatched_to = $request->input('time_dispatched_to');

            try {
                $referral->save();

                foreach ($request->input('referralReasonIds') as $referralReasonId) {
                    ReferralReason::find($referralReasonId)
                        ->referral()
                        ->attach($referral);
                }

                return response()->json(
                    Test::find($request->input('test_id'))->load(
                        'testStatus',
                        'specimen.specimenType',
                        'testType.specimenTypes',
                        'testType.measures.measureType',
                        'testType.measures.measureRanges',
                        'testType.measures.results',
                        'results.measure.measureType',
                        'results.measure.measureRanges'
                    ));

            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    /**
     * Start Test
     * this is useful to pick up information from automated machine
     * that does not send user information
     */
    public function start($id)
    {
        $test = Test::find($id);
        $test->tested_by = Auth::user()->id;
        $test->test_status_id = TestStatus::started;
        $test->time_started = date('Y-m-d H:i:s');
        $test->save();

        return response()->json(
            Test::find($id)->load(
                'testStatus',
                'specimen.specimenType',
                'testType.specimenTypes',
                'testType.measures.measureType',
                'testType.measures.measureRanges',
                'testType.measures.results',
                'results.measure.measureType',
                'results.measure.measureRanges'
        ));
    }

    /**
     * Verify Test
     *
     * @param
     * @return
     */
    public function verify($id)
    {
        $test = Test::find($id);
        $test->test_status_id = TestStatus::verified;
        $test->time_verified = date('Y-m-d H:i:s');
        $test->verified_by = Auth::user()->id;
        $test->save();

        // sending to emr on verification
        EMR::sendTestResults($id);

        return response()->json(
            Test::find($id)->load(
                'testStatus',
                'specimen.specimenType',
                'testType.specimenTypes',
                'testType.measures.measureType',
                'testType.measures.measureRanges',
                'testType.measures.results',
                'results.measure.measureType',
                'results.measure.measureRanges'
        ));
    }
}
