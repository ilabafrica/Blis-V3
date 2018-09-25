<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use EMR;
use Auth;
use App\Models\Test;
use App\Models\Result;
use App\Models\TestStatus;
use Illuminate\Http\Request;
use App\Models\AntibioticSusceptibility;
use App\Models\SusceptibilityBreakPoint;

class ResultController extends Controller
{
    public function show($id)
    {
        $result = Result::find($id)->load('measureRange');

        return response()->json($result);
    }

    public function store(Request $request)
    {
        if ($request->input('measure_range_id')) {
            $rules = [
                'test_id' => 'required',
                'measure_id' => 'required',
                'measure_range_id' => 'required',
            ];
        } else {
            $rules = [
                'test_id' => 'required',
                'measures' => 'required',
            ];
        }
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $test = Test::find($request->input('test_id'));
            $test->test_status_id = TestStatus::completed;
            $test->tested_by = Auth::user()->id;
            $results = $request->input('measures');

            // to store isolated organism
            if ($test->testType->culture) {
                $result = Result::updateOrCreate([
                    'test_id' => $request->input('test_id'),
                    'measure_range_id' => $request->input('measure_range_id'),
                    'measure_id' => $request->input('measure_id'),
                ]);
                $result->time_entered = date('Y-m-d H:i:s');
                $result->save();
            } else {
                foreach ($test->testType->measures as $measure) {
                    if ($measure->measureType->isMultiAlphanumeric()) {
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
                    } elseif ($measure->measureType->isAlphanumeric()) {
                        // alphanumeric
                        $result = Result::updateOrCreate([
                            'measure_id' => $measure->id,
                            'test_id' => $request->input('test_id'),
                        ]);
                        $result->time_entered = date('Y-m-d H:i:s');
                        $result->measure_range_id = $results[$measure->id]['measure_range_id'];
                        $result->save();
                    } elseif ($measure->measureType->isFreeText() ||
                        $measure->measureType->isNumeric()) {
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
            }
            $test->save();
            // sending to emr on completion for now
            EMR::sendTestResults($test->id);

            return response()->json(Test::find($test->id)->loader());
        }
    }

    public function susceptibility(Request $request)
    {
        $rules = [
            'antibiotic_id' => 'required',
            'result_id' => 'required',
        ];

        if ($request->input('zone_diameter') == '') {
            $rules['susceptibility_range_id'] = 'required';
        }
        $request->validate($rules);

        $susceptibilityBreakPoint = SusceptibilityBreakPoint::where(
                'antibiotic_id', $request->input('antibiotic_id')
            )->where('measure_range_id', $request->input('measure_range_id'))->get()->first();

        if ($request->input('zone_diameter') != '') {
            $susceptibilityRangeId = $susceptibilityBreakPoint
                ->getSusceptibilityRange($request->input('zone_diameter'));
            $susceptibilityZoneDiameter = $request->input('zone_diameter');
        } else {
            $susceptibilityRangeId = $request->input('susceptibility_range_id');
            $susceptibilityZoneDiameter = null;
        }

        if ($request->input('antibiotic_susceptibility_id') != '') {
            $antibioticSusceptibility = AntibioticSusceptibility::find($request->input('antibiotic_susceptibility_id'));
        } else {
            $antibioticSusceptibility = new AntibioticSusceptibility;
        }
        $antibioticSusceptibility = AntibioticSusceptibility::updateOrCreate([
            'antibiotic_id' => $request->input('antibiotic_id'),
            'result_id' => $request->input('result_id'),
        ]);

        $antibioticSusceptibility->antibiotic_id = $request->input('antibiotic_id');
        $antibioticSusceptibility->result_id = $request->input('result_id');
        $antibioticSusceptibility->susceptibility_range_id = $susceptibilityRangeId;
        $antibioticSusceptibility->user_id = Auth::user()->id;
        $antibioticSusceptibility->zone_diameter = $susceptibilityZoneDiameter;

        $antibioticSusceptibility->save();

        return response()->json(AntibioticSusceptibility::find($antibioticSusceptibility->id)
            ->load(
                'susceptibilityRange',
                'result.measureRange',
                'antibiotic'
            )
        );
    }

    public function deleteSusceptibility($id)
    {
        try {
            return response()->json(AntibioticSusceptibility::destroy($id), 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function deleteOrganism($id)
    {
        try {
            return response()->json(Result::destroy($id), 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
