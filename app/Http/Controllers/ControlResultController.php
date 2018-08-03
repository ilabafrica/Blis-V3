<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Http\Request;
use App\Models\ControlResult;
use App\Models\ControlTest;
use App\Models\ControlTestStatus;

class ControlResultController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $rules = [
            'control_test_id' => 'required',
            'measures' => 'required',
        ];

\Log::info($request->all());
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator);

        } else {
            $controlTest = ControlTest::find($request->input('control_test_id'));
            $results = $request->input('measures');
            foreach ($controlTest->testType->measures as $measure) {

                if($measure->measureType->isMultiAlphanumeric()){
                    // multi alphanumeric
                    foreach ($results[$measure->id]['measureRanges'] as $measureRange) {

                        $controlResult = ControlResult::firstOrCreate([
                            'control_test_id' => $request->input('control_test_id'),
                            'measure_range_id' => $measureRange['measure_range_id'],
                            'measure_id' => $measure->id,
                        ]);
                    }

                }else if($measure->measureType->isAlphanumeric()){
                    // alphanumeric
                    $controlResult = ControlResult::firstOrCreate([
                        'control_test_id' => $request->input('control_test_id'),
                        'measure_id' => $measure->id
                    ]);
                    $controlResult->measure_range_id = $results[$measure->id]['measure_range_id'];
                    $controlResult->save();

                }else if($measure->measureType->isFreeText()||
                    $measure->measureType->isNumeric()){
                    // free text | numeric
                    $controlResult = ControlResult::firstOrCreate([
                        'control_test_id' => $request->input('control_test_id'),
                        'measure_id' => $measure->id
                    ]);
                    $controlResult->result = $results[$measure->id]['result'];
                    $controlResult->save();

                }
            }
            // give lot the expected result, for numeric, alphanumeric and free text... would be completed, manully passed, manual verification
            $controlTest->control_test_status_id = ControlTestStatus::passed;
            $controlTest->save();

            return response()->json($controlTest);
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
        $controlResult = ControlResult::findOrFail($id);

        return response()->json($controlResult);
    }
}
