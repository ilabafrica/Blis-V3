<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Http\Request;
use App\Models\QualityControl;

class QualityControlController extends Controller
{
    public function index()
    {
        $qualityControl = QualityControl::orderBy('id', 'ASC')->paginate(20);
        return response()->json($qualityControl);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'lot_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $qualityControl = new QualityControl;
            $qualityControl->name = $request->input('name');
            $qualityControl->description = $request->input('description');
            $qualityControl->lot_id = $request->input('lot_id');

            try {
                $qualityControl->save();
                return response()->json($qualityControl);
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
        $qualityControl = QualityControl::findOrFail($id);
        return response()->json($qualityControl);
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
        $rules = array(
            'name' => 'required',
            'lot_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $qualityControl = QualityControl::findOrFail($id);
            $qualityControl->name = $request->input('name');
            $qualityControl->description = $request->input('description');
            $qualityControl->lot_id = $request->input('lot_id');

            try {
                $qualityControl->save();
                return response()->json($qualityControl);
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
            $qualityControl = QualityControl::findOrFail($id);
            $qualityControl->delete();
            return response()->json($qualityControl, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}