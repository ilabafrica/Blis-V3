<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizationContact;

class OrganizationContactController extends Controller
{
    public function index()
    {
        $organizationcontact = OrganizationContact::orderBy('id', 'ASC')->paginate(20);

        return response()->json($organizationcontact);
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
        'organization_id' => 'required',
        'purpose' => 'required',
        'name' => 'required',
        'telecom' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $organizationcontact = new OrganizationContact;
            $organizationcontact->organization_id = $request->input('organization_id');
            $organizationcontact->purpose = $request->input('purpose');
            $organizationcontact->name = $request->input('name');
            $organizationcontact->telecom = $request->input('telecom');
            $organizationcontact->address = $request->input('address');

            try {
                $organizationcontact->save();

                return response()->json($organizationcontact);
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
            $organizationcontact = OrganizationContact::findorfail($id);

            return response()->json($organizationcontact);
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
        'organization_id' => 'required',
        'purpose' => 'required',
        'name' => 'required',
        'telecom' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $organizationcontact = OrganizationContact::findorfail($id);
            $organizationcontact->organization_id = $request->input('organization_id');
            $organizationcontact->purpose = $request->input('purpose');
            $organizationcontact->name = $request->input('name');
            $organizationcontact->telecom = $request->input('telecom');
            $organizationcontact->address = $request->input('address');

            try {
                $organizationcontact->save();

                return response()->json($organizationcontact);
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
            $organizationcontact = OrganizationContact::findorfail($id);
            $organizationcontact->delete();

            return response()->json($organizationcontact, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
        }
    }
}
