<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use Illuminate\Http\Request;
use App\Models\EncounterStatus;

class EncounterStatusController extends Controller
{
    public function index()
    {
        $encounterStatus = EncounterStatus::orderBy('id', 'ASC')->paginate(10);

        return response()->json($encounterStatus);
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
            'name' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);
        } else {
            $encounterStatus = new EncounterStatus;
            $encounterStatus->name = $request->input('name');

            try {
                $encounterStatus->save();

                return response()->json($encounterStatus);
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
        $encounterStatus = EncounterStatus::findOrFail($id);

        return response()->json($encounterStatus);
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
            'name' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $encounterStatus = EncounterStatus::findOrFail($id);
            $encounterStatus->name = $request->input('name');

            try {
                $encounterStatus->save();

                return response()->json($encounterStatus);
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
            $encounterStatus = EncounterStatus::findOrFail($id);
            $encounterStatus->delete();

            return response()->json($encounterStatus, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
