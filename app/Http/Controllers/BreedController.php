<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use App\Models\Breed;
use Illuminate\Http\Request;

class BreedController extends Controller
{
    public function index()
    {
        $breed = Breed::orderBy('id', 'ASC')->paginate(20);

        return response()->json($breed);
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
            'species_id' => 'required',
            'code' => 'required',
            'display' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $breed = new Breed;
            $breed->species_id = $request->input('species_id');
            $breed->code = $request->input('code');
            $breed->display = $request->input('display');

            try {
                $breed->save();

                return response()->json($breed);
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
        $breed = Breed::findOrFail($id);

        return response()->json($breed);
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
            'species_id' => 'required',
            'code' => 'required',
            'display' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $breed = Breed::findOrFail($id);
            $breed->species_id = $request->input('species_id');
            $breed->code = $request->input('code');
            $breed->display = $request->input('display');

            try {
                $breed->save();

                return response()->json($breed);
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
            $breed = Breed::findOrFail($id);
            $breed->delete();

            return response()->json($breed, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
