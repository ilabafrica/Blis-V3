<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use App\Models\Lot;
use Illuminate\Http\Request;

class LotController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('search')) {
            $search = $request->query('search');
            $lot = Lot::with('instrument')->where('number', 'LIKE', "%{$search}%")
                ->paginate(10);
        } else {
            $lot = Lot::with('instrument')->orderBy('id', 'ASC')->paginate(10);
        }

        return response()->json($lot);
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
            //'number' => 'required',
            //'expiry' => 'required',
            //'instrument_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $lot = new Lot;
            $lot->number = $request->input('number');
            $lot->description = $request->input('description');
            $lot->expiry = $request->input('expiry');
            $lot->instrument_id = $request->input('instrument_id');
            try {
                $lot->save();

                return response()->json($lot);
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
        $lot = Lot::findOrFail($id);

        return response()->json($lot);
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
            'number' => 'required',
            'expiry' => 'required',
            'instrument_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $lot = Lot::findOrFail($id);
            $lot->number = $request->input('number');
            $lot->description = $request->input('description');
            $lot->expiry = $request->input('expiry');
            $lot->instrument_id = $request->input('instrument_id');

            try {
                $lot->save();

                return response()->json($lot);
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
            $lot = Lot::findOrFail($id);
            $lot->delete();

            return response()->json($lot, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
