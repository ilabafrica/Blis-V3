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

class ControlResultController extends Controller
{
    public function index()
    {
        $controlResult = ControlResult::orderBy('id', 'ASC')->get();

        return response()->json($controlResult);
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
            /*'results' => 'required',
            'control_measure_id' => 'required',
            'control_test_id' => 'required',*/
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $controlResults = [];
            $input = $request->all();
            foreach ($input as $index => $value) {
                if($value){
                    if(is_array($value['result'])){
                        $this->storeMultiAlpha($value);
                    }else{
                        $controlResult = new ControlResult;
                        $controlResult->result = $value['result'];
                        $controlResult->measure_id = $value['measure_id'];
                        $controlResult->control_test_id = $value['control_test_id'];

                        if($value['measure_ranges_id']){
                            foreach ($value['measure_ranges_id'] as $measure_range) {
                                if ($value['result'] === $measure_range['display']){
                                    $controlResult->measure_range_id = $measure_range['id'];
                                }
                            }
                        }
                        try {
                            $controlResult->save();
                            $controlResults[] = $controlResult;
                            
                        } catch (\Illuminate\Database\QueryException $e) {
                            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                        }
                    }
                }
            }

            return response()->json($controlResults);
        }
    }

    public function storeMultiAlpha($value){
        
        foreach ($value['result'] as $result) {
            $controlResult = new ControlResult;
            $controlResult->result = $result;
            $controlResult->measure_id = $value['measure_id'];
            $controlResult->control_test_id = $value['control_test_id'];

            if($value['measure_ranges_id']){
                foreach ($value['measure_ranges_id'] as $measure_range) {
                    if ($result === $measure_range['display']){
                        $controlResult->measure_range_id = $measure_range['id'];
                    }
                }
            }

            try {
                $controlResult->save();
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
        $controlResult = ControlResult::findOrFail($id);

        return response()->json($controlResult);
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
            'results' => 'required',
            'control_measure_id' => 'required',
            'control_test_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $controlResult = ControlResult::findOrFail($id);
            $controlResult->results = $request->input('results');
            $controlResult->control_measure_id = $request->input('control_measure_id');
            $controlResult->control_test_id = $request->input('control_test_id');

            try {
                $controlResult->save();

                return response()->json($controlResult);
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
            $controlResult = ControlResult::findOrFail($id);
            $controlResult->delete();

            return response()->json($controlResult, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
