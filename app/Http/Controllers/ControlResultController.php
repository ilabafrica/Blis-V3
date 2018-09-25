<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use App\Models\ControlTest;
use Illuminate\Http\Request;
use App\Models\ControlResult;
use App\Models\ControlTestStatus;

class ControlResultController extends Controller
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
            'control_test_id' => 'required',
            'measures' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $controlTest = ControlTest::find($request->input('control_test_id'));
            $controlTest->control_test_status_id = ControlTestStatus::completed;
            $results = $request->input('measures');
            foreach ($controlTest->testType->measures as $measure) {
                if ($measure->measureType->isMultiAlphanumeric()) {
                    // multi alphanumeric
                    foreach ($results[$measure->id]['measureRanges'] as $measureRange) {
                        $controlResult = ControlResult::updateOrCreate([
                            'control_test_id' => $request->input('control_test_id'),
                            'measure_range_id' => $measureRange['measure_range_id'],
                            'measure_id' => $measure->id,
                        ]);
                    }
                } elseif ($measure->measureType->isAlphanumeric()) {
                    // alphanumeric
                    $controlResult = ControlResult::updateOrCreate([
                        'control_test_id' => $request->input('control_test_id'),
                        'measure_id' => $measure->id,
                    ]);
                    $controlResult->measure_range_id = $results[$measure->id]['measure_range_id'];
                    $controlResult->save();
                } elseif ($measure->measureType->isFreeText() ||
                    $measure->measureType->isNumeric()) {
                    // free text | numeric
                    $controlResult = ControlResult::updateOrCreate([
                        'control_test_id' => $request->input('control_test_id'),
                        'measure_id' => $measure->id,
                    ]);
                    $controlResult->result = $results[$measure->id]['result'];
                    $controlResult->save();
                }
            }
            $controlTest->save();

            return response()->json(ControlTest::find($controlTest->id)->load(
                'lot.instrument',
                'controlTestStatus',
                'testType.measures.measureType',
                'testType.measures.measureRanges',
                'testType.measures.controlResults',
                'controlResults.measure.measureType',
                'controlResults.measure.measureRanges'
            ));
        }
    }
}
