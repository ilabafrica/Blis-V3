<?php

namespace App\Http\Controllers;

use App\Models\ContactPoint;
use Illuminate\Http\Request;

class ContactPointController extends Controller
{
    public function index()
    {
        $contactpoint = ContactPoint::orderBy('id', 'ASC')->paginate(20);

        return response()->json($contactpoint);
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
        'created_by' => 'required',
        'system' => 'required',
        'value' => 'required',
        'use' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $contactpoint = new ContactPoint;
            $contactpoint->created_by = $request->input('created_by');
            $contactpoint->system = $request->input('system');
            $contactpoint->value = $request->input('value');
            $contactpoint->use = $request->input('use');
            $contactpoint->rank = $request->input('rank');
            $contactpoint->period = $request->input('period');

            try {
                $contactpoint->save();

                return response()->json($contactpoint);
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
            $contactpoint = ContactPoint::findorfail($id);

            return response()->json($contactpoint);
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
        'created_by' => 'required',
        'system' => 'required',
        'value' => 'required',
        'use' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $contactpoint = ContactPoint::findorfail($id);
            $contactpoint->created_by = $request->input('created_by');
            $contactpoint->system = $request->input('system');
            $contactpoint->value = $request->input('value');
            $contactpoint->use = $request->input('use');
            $contactpoint->rank = $request->input('rank');
            $contactpoint->period = $request->input('period');

            try {
                $contactpoint->save();

                return response()->json($contactpoint);
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
            $contactpoint = ContactPoint::findorfail($id);
            $contactpoint->delete();

            return response()->json($contactpoint, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
        }
    }
}
