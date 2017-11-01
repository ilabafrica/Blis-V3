<?php

namespace App\Http\Controllers;

use App\Models\CareTeam;
use Illuminate\Http\Request;

class CareTeamController extends Controller
{
    public function index()
    {
        $careteam = CareTeam::orderBy('id', 'ASC')->paginate(20);

        return response()->json($careteam);
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
        'status_id' => 'required',
        'category' => 'required',
        'name' => 'required',
        'context' => 'required',
        'organization_id' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $careteam = new CareTeam;
            $careteam->identifiers = $request->input('identifiers');
            $careteam->status_id = $request->input('status_id');
            $careteam->category = $request->input('category');
            $careteam->name = $request->input('name');
            $careteam->subject = $request->input('subject');
            $careteam->context = $request->input('context');
            $careteam->period = $request->input('period');
            $careteam->reason_code = $request->input('reason_code');
            $careteam->reason_reference = $request->input('reason_reference');
            $careteam->organization_id = $request->input('organization_id');
            $careteam->comment = $request->input('comment');

            try {
                $careteam->save();

                return response()->json($careteam);
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
            $careteam = CareTeam::findorfail($id);

            return response()->json($careteam);
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
        'status_id' => 'required',
        'category' => 'required',
        'name' => 'required',
        'context' => 'required',
        'organization_id' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $careteam = CareTeam::findorfail($id);
            $careteam->identifiers = $request->input('identifiers');
            $careteam->status_id = $request->input('status_id');
            $careteam->category = $request->input('category');
            $careteam->name = $request->input('name');
            $careteam->subject = $request->input('subject');
            $careteam->context = $request->input('context');
            $careteam->period = $request->input('period');
            $careteam->reason_code = $request->input('reason_code');
            $careteam->reason_reference = $request->input('reason_reference');
            $careteam->organization_id = $request->input('organization_id');
            $careteam->comment = $request->input('comment');

            try {
                $careteam->save();

                return response()->json($careteam);
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
            $careteam = CareTeam::findorfail($id);
            $careteam->delete();

            return response()->json($careteam, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
        }
    }
}
