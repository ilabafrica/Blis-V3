<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EpisodeofCare;

class EpisodeofCareController extends Controller
{
    public function index()
    {
        $episodeofcare = EpisodeofCare::orderBy('id', 'ASC')->paginate(20);

        return response()->json($episodeofcare);
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
        'status' => 'required',
        'type' => 'required',
        'patient' => 'required',
        'organization_id' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $episodeofcare = new EpisodeofCare;
            $episodeofcare->status = $request->input('status');
            $episodeofcare->type = $request->input('type');
            $episodeofcare->patient = $request->input('patient');
            $episodeofcare->organization_id = $request->input('organization_id');
            $episodeofcare->period = $request->input('period');
            $episodeofcare->practitioners_id = $request->input('practitioners_id');
            $episodeofcare->team_id = $request->input('team_id');

            try {
                $episodeofcare->save();

                return response()->json($episodeofcare);
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
            $episodeofcare = EpisodeofCare::findorfail($id);

            return response()->json($episodeofcare);
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
        'status' => 'required',
        'type' => 'required',
        'patient' => 'required',
        'organization_id' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $episodeofcare = EpisodeofCare::findorfail($id);
            $episodeofcare->status = $request->input('status');
            $episodeofcare->type = $request->input('type');
            $episodeofcare->patient = $request->input('patient');
            $episodeofcare->organization_id = $request->input('organization_id');
            $episodeofcare->period = $request->input('period');
            $episodeofcare->practitioners_id = $request->input('practitioners_id');
            $episodeofcare->team_id = $request->input('team_id');

            try {
                $episodeofcare->save();

                return response()->json($episodeofcare);
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
            $episodeofcare = EpisodeofCare::findorfail($id);
            $episodeofcare->delete();

            return response()->json($episodeofcare, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
        }
    }
}
