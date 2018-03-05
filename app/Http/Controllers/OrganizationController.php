<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $organization = Organization::orderBy('id', 'ASC')->paginate(20);

        return response()->json($organization);
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
            'active' => 'required',
            'organization_type_id' => 'required',
            'name' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $organization = new Organization;
            $organization->identifier = $request->input('identifier');
            $organization->created_by = $request->input('created_by');
            $organization->active = $request->input('active');
            $organization->organization_type_id = $request->input('organization_type_id');
            $organization->name = $request->input('name');
            $organization->alias = $request->input('alias');
            $organization->telecom = $request->input('telecom');
            $organization->address = $request->input('address');

            try {
                $organization->save();

                return response()->json($organization);
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
        $organization = Organization::findOrFail($id);

        return response()->json($organization);
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
            'active' => 'required',
            'organization_type_id' => 'required',
            'name' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $organization = Organization::findOrFail($id);
            $organization->identifier = $request->input('identifier');
            $organization->created_by = $request->input('created_by');
            $organization->active = $request->input('active');
            $organization->organization_type_id = $request->input('organization_type_id');
            $organization->name = $request->input('name');
            $organization->alias = $request->input('alias');
            $organization->telecom = $request->input('telecom');
            $organization->address = $request->input('address');

            try {
                $organization->save();

                return response()->json($organization);
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
            $organization = Organization::findOrFail($id);
            $organization->delete();

            return response()->json($organization, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
