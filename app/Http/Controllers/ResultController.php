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
use App\Models\Result;
use App\Models\TestStatus;
use Illuminate\Http\Request;

class ResultController extends Controller
{
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
            'measures' => 'required',
        ];
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator,422);

        } else {

            $test = Test::find($request->input('test_id'));
            $test->test_status_id = TestStatus::completed;
            $test->tested_by = Auth::user()->id;
            $results = $request->input('measures');
            foreach ($test->testType->measures as $measure) {

                if($measure->measureType->isMultiAlphanumeric()){
                    // multi alphanumeric
                    foreach ($results[$measure->id]['measureRanges'] as $measureRange) {

                        $result = Result::updateOrCreate([
                            'test_id' => $request->input('test_id'),
                            'measure_range_id' => $measureRange['measure_range_id'],
                            'measure_id' => $measure->id,
                        ]);
                        $result->time_entered = date('Y-m-d H:i:s');
                        $result->save();
                    }

                }else if($measure->measureType->isAlphanumeric()){
                    // alphanumeric
                    $result = Result::updateOrCreate([
                        'measure_id' => $measure->id,
                        'test_id' => $request->input('test_id'),
                    ]);
                    $result->time_entered = date('Y-m-d H:i:s');
                    $result->measure_range_id = $results[$measure->id]['measure_range_id'];
                    $result->save();

                }else if($measure->measureType->isFreeText()||
                    $measure->measureType->isNumeric()){
                    // free text | numeric
                    $result = Result::updateOrCreate([
                        'measure_id' => $measure->id,
                        'test_id' => $request->input('test_id'),
                    ]);
                    $result->time_entered = date('Y-m-d H:i:s');
                    $result->result = $results[$measure->id]['result'];
                    $result->save();
                }
            }
            $test->save();
            // sending to emr on completion for now
            EMR::sendTestResults($test->id);

            return response()->json(Test::find($test->id)->load(
                'testStatus.testPhase',
                'specimen.specimenType',
                'testType.specimenTypes',
                'testType.measures.results',
                'results.measure.measureType',
                'results.measure.measureRanges',
                'testType.measures.measureType',
                'testType.measures.measureRanges'
            ));
        }
    }
}
