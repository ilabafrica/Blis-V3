<?php

namespace App\Http\Controllers;

use App\Models\SpecimenType;
use App\Models\TestType;
use App\Models\SpecimenTypeTestType;
use Illuminate\Http\Request;

class SpecimenTypeTestTypeController extends Controller
{
    public function index()
    {
        $specimentypesTesttypes = SpecimenTypeTestType::all();

        return response()->json($specimentypesTesttypes);
    }

    public function create(Request $request)
    {   
        $input = $request->all();
        $specimen_types = $request->input('specimen_type');
        for ($i = 0; $i < count($input)-1; $i++) {
            $specimentypetesttype = new SpecimenTypeTestType;
            $specimentypetesttype->specimen_type_id = $input[$i];
            $specimentypetesttype->test_type_id = array_search(null, $input);
                try {
                    $specimentypetesttype->save();
                } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }                
            }
    }

    public function attach(Request $request)
    {
        $rules = [
            'specimen_id' => 'required',
            'test_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $specimenType = SpecimenType::find($request->input('specimen_id'));
            $testType = TestType::find($request->input('test_id'));

            try {
                $specimenType->testType()->attach($testType);

                return response()->json(['message' => 'Item Successfully inserted']);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    public function detach(Request $request)
    {
        $rules = [
            'specimen_id' => 'required',
            'test_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $specimenType = SpecimenType::find($request->input('specimen_id'));
            $testType = TestType::find($request->input('test_id'));

            try {
                $specimenType->testType()->detach($testType);

                return response()->json(['message' => 'Item Successfully deleted']);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
}
