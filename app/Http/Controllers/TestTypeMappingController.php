<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use App\Models\TestType;
use App\Models\SpecimenType;
use Illuminate\Http\Request;
use App\Models\TestTypeMapping;

class TestTypeMappingController extends Controller
{
    public function index()
    {
        $testMapping = TestTypeMapping::all();

        return response()->json($testMapping);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $specimen_types = $request->input('specimen_type');
        for ($i = 0; $i < count($input) - 1; $i++) {
            $testMapping = new TestTypeMapping;
            $testMapping->specimen_type_id = $input[$i];
            $testMapping->test_type_id = array_search(null, $input);
            try {
                $testMapping->save();
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
    public function update(Request $request)
    {
        $input = $request->all();

        for ($i = 0; $i < count($input) - 1; $i++) {
            if (TestTypeMapping::where('test_type_id', '=', array_search(null, $input))->where('specimen_type_id', '=', $input[$i])->exists()) {
                //if the specimen is unchanged
            } else {
                //if a new specimen has been selected
                $testMapping = new TestTypeMapping;
                $testMapping->specimen_type_id = $input[$i];
                $testMapping->test_type_id = array_search(null, $input);
                try {
                    $testMapping->save();
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            }
        }

        //Delete Unselected Specimens
        $allMappings = TestTypeMapping::where('test_type_id', '=', array_search(null, $input))->pluck('specimen_type_id')->toArray();
        $unselectedSpecimens = array_diff($allMappings, $input);

        if (empty($unselectedSpecimens)) {
            //no specimens have been deselected
        } else {
            foreach ($unselectedSpecimens as $index => $id) {
                try {
                    $testMapping = TestTypeMapping::where('test_type_id', '=', array_search(null, $input))->where('specimen_type_id', '=', $id)->firstOrFail();
                    $testMapping->delete();
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            }
        }
    }

    public function attach(Request $request)
    {
        $rules = [
            'specimen_type_id' => 'required',
            'test_type_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $specimenType = SpecimenType::find($request->input('specimen_type_id'));
            $testType = TestType::find($request->input('test_type_id'));

            try {
                $specimenType->testTypes()->attach($testType);

                return response()->json(['message' => 'Item Successfully inserted']);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    public function detach(Request $request)
    {
        $rules = [
            'specimen_type_id' => 'required',
            'test_type_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $specimenType = SpecimenType::find($request->input('specimen_type_id'));
            $testType = TestType::find($request->input('test_type_id'));

            try {
                $specimenType->testTypes()->detach($testType);

                return response()->json(['message' => 'Item Successfully deleted']);
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
