<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Auth;
use App\Models\Name;
use App\Models\Gender;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('search')) {
            $search = $request->query('search');
            $patient = Patient::whereHas('name', function ($query) use ($search) {
                $query->where('given', 'LIKE', "%{$search}%")->orWhere('family', 'LIKE', "%{$search}%");
            })->with('gender', 'name')
                ->paginate(10);
        } else {
            $patient = Patient::with('name', 'gender')->orderBy('id', 'ASC')->paginate(20);
        }

        return response()->json($patient);
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
            'identifier' => 'required',
            'birth_date' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $name = new Name;
            $name->text = $request->input('family');
            $name->family = $request->input('family');
            $name->given = $request->input('given');

            try {
                $name->save();
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }

            $gender = new Gender;
            $gender->code = $request->input('gender');
            $gender->display = ucfirst($request->input('gender'));

            try {
                $gender->save();
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }

            $patient = new Patient;
            $patient->identifier = $request->input('identifier');
            $patient->name_id = $name->id;
            $patient->gender_id = $gender->id;
            $patient->birth_date = $request->input('birth_date');
            $patient->created_by = Auth::user()->id;

            try {
                $patient->save();
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }

            return response()->json($patient);
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
        $patient = Patient::findOrFail($id);

        return response()->json($patient);
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
            'identifier' => 'required',
            'name_id' => 'required',
            'gender_id' => 'required',
            'birth_date' => 'required',
            'created_by' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $patient = Patient::findOrFail($id);
            $patient->identifier = $request->input('identifier');
            $patient->active = $request->input('active');
            $patient->name_id = $request->input('name_id');
            $patient->gender_id = $request->input('gender_id');
            $patient->birth_date = $request->input('birth_date');
            $patient->deceased = $request->input('deceased');
            $patient->deceased_date_time = $request->input('deceased_date_time');
            $patient->address_id = $request->input('address_id');
            $patient->marital_status = $request->input('marital_status');
            $patient->photo = $request->input('photo');
            $patient->gender_status = $request->input('gender_status');
            $patient->organization_id = $request->input('organization_id');
            $patient->created_by = $request->input('created_by');

            $name = Name::findOrFail($request->input('name.id'));
            $name->family = $request->input('name.family');
            $name->given = $request->input('name.given');

            $gender = Gender::findOrFail($request->input('gender.id'));
            $gender->code = $request->input('gender.display');
            $gender->display = ucfirst($request->input('gender.display'));

            try {
                $patient->save();
                $name->save();
                $gender->save();

                return response()->json($patient);
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
            $patient = Patient::findOrFail($id);
            $patient->delete();

            return response()->json($patient, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
