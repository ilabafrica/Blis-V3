<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use App\Models\TestTypeMapping;
use Illuminate\Http\Request;

class TestTypeMappingController extends Controller
{
    public function index()
    {
        $testMapping = TestTypeMapping::orderBy('id', 'ASC')->paginate(20);

        return response()->json($testMapping);
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
            'test_type_id' => 'required',
            'specimen_type_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $testMapping = new TestTypeMapping;
            $testMapping->code_id = $request->input('code_id');
            $testMapping->test_type_id = $request->input('test_type_id');
            $testMapping->specimen_type_id = $request->input('specimen_type_id');

            try {
                $testMapping->save();

                return response()->json($testMapping);
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
        $testMapping = TestTypeMapping::findOrFail($id);

        return response()->json($testMapping);
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
            'test_type_id' => 'required',
            'specimen_type_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $testMapping = TestTypeMapping::findOrFail($id);
            $testMapping->code_id = $request->input('code_id');
            $testMapping->test_type_id = $request->input('test_type_id');
            $testMapping->specimen_type_id = $request->input('specimen_type_id');

            try {
                $testMapping->save();

                return response()->json($testMapping);
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
            $testMapping = TestTypeMapping::findOrFail($id);
            $testMapping->delete();

            return response()->json($testMapping, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
