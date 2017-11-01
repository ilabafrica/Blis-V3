<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CodeableConcept;

class CodeableConceptController extends Controller
{
    public function index()
    {
        $codeableconcept = CodeableConcept::orderBy('id', 'ASC')->paginate(20);

        return response()->json($codeableconcept);
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
        'code' => 'required',
        'description' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $codeableconcept = new CodeableConcept;
            $codeableconcept->code = $request->input('code');
            $codeableconcept->description = $request->input('description');

            try {
                $codeableconcept->save();

                return response()->json($codeableconcept);
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
        try {
            $codeableconcept = CodeableConcept::findorfail($id);

            return response()->json($codeableconcept);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
        }
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
        'code' => 'required',
        'description' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $codeableconcept = CodeableConcept::findorfail($id);
            $codeableconcept->code = $request->input('code');
            $codeableconcept->description = $request->input('description');

            try {
                $codeableconcept->save();

                return response()->json($codeableconcept);
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
            $codeableconcept = CodeableConcept::findorfail($id);
            $codeableconcept->delete();

            return response()->json($codeableconcept, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
        }
    }
}
