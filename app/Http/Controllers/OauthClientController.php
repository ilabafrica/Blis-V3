<?php

namespace App\Http\Controllers;

use App\Models\OauthClient;
use Illuminate\Http\Request;

class OauthClientController extends Controller
{
    public function index()
    {
        $oauthclient = OauthClient::orderBy('id', 'ASC')->paginate(20);

        return response()->json($oauthclient);
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
        'secret' => 'required',
        'redirect' => 'required',
        'personal_access_client' => 'required',
        'password_client' => 'required',
        'revoked' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $oauthclient = new OauthClient;
            $oauthclient->created_by = $request->input('created_by');
            $oauthclient->name = $request->input('name');
            $oauthclient->secret = $request->input('secret');
            $oauthclient->redirect = $request->input('redirect');
            $oauthclient->personal_access_client = $request->input('personal_access_client');
            $oauthclient->password_client = $request->input('password_client');
            $oauthclient->revoked = $request->input('revoked');

            try {
                $oauthclient->save();

                return response()->json($oauthclient);
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
            $oauthclient = OauthClient::findorfail($id);

            return response()->json($oauthclient);
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
        'name' => 'required',
        'secret' => 'required',
        'redirect' => 'required',
        'personal_access_client' => 'required',
        'password_client' => 'required',
        'revoked' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $oauthclient = OauthClient::findorfail($id);
            $oauthclient->created_by = $request->input('created_by');
            $oauthclient->name = $request->input('name');
            $oauthclient->secret = $request->input('secret');
            $oauthclient->redirect = $request->input('redirect');
            $oauthclient->personal_access_client = $request->input('personal_access_client');
            $oauthclient->password_client = $request->input('password_client');
            $oauthclient->revoked = $request->input('revoked');

            try {
                $oauthclient->save();

                return response()->json($oauthclient);
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
            $oauthclient = OauthClient::findorfail($id);
            $oauthclient->delete();

            return response()->json($oauthclient, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
        }
    }
}
