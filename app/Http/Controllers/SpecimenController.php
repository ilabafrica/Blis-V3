<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Auth;
use App\Models\Specimen;
use Illuminate\Http\Request;

class SpecimenController extends Controller
{
    public function index()
    {
        $specimen = Specimen::orderBy('id', 'ASC')->paginate(10);

        return response()->json($specimen);
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
            'specimen_type_id' => 'required',
            'received_by' => 'required',
            'collected_by' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $specimen = new Specimen;
            $specimen->identifier = $request->input('identifier');
            $specimen->accession_identifier = $request->input('accession_identifier');
            $specimen->specimen_type_id = $request->input('specimen_type_id');
            $specimen->parent_id = $request->input('parent_id');
            $specimen->specimen_status_id = $request->input('specimen_status_id');
            $specimen->received_by = Auth::user()->id;
            $specimen->collected_by = $request->input('collected_by');
            $specimen->time_collected = $request->input('time_collected');
            $specimen->time_received = $request->input('time_received');

            try {
                $specimen->save();
                return response()->json($specimen);
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
        $specimen = Specimen::findOrFail($id);

        return response()->json($specimen);
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
            'accession_identifier' => 'required',
            'specimen_type_id' => 'required',
            'parent_id' => 'required',
            'specimen_status_id' => 'required',
            'received_by' => 'required',
            'collected_by' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $specimen = Specimen::findOrFail($id);
            $specimen->identifier = $request->input('identifier');
            $specimen->accession_identifier = $request->input('accession_identifier');
            $specimen->specimen_type_id = $request->input('specimen_type_id');
            $specimen->parent_id = $request->input('parent_id');
            $specimen->specimen_status_id = $request->input('specimen_status_id');
            $specimen->received_by = $request->input('received_by');
            $specimen->collected_by = $request->input('collected_by');
            $specimen->time_collected = $request->input('time_collected');
            $specimen->time_received = $request->input('time_received');

            try {
                $specimen->save();

                return response()->json($specimen);
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
            $specimen = Specimen::findOrFail($id);
            $specimen->delete();

            return response()->json($specimen, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
