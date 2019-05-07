<?php

namespace App\Http\Controllers;

use Auth;
use App\ThirdPartyApp;
use Illuminate\Http\Request;
use App\Models\ThirdPartyAccess;

class ThirdPartyAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ThirdPartyApp::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ThirdPartyApp  $thirdPartyApp
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ThirdPartyApp  $thirdPartyApp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ThirdPartyApp  $thirdPartyApp
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Access of BLIS to the third party application.
     *
     * @param  \App\ThirdPartyApp  $thirdPartyApp
     * @return \Illuminate\Http\Response
     */
    public function access(Request $request)
    {
        $fields = [
            'username',
            'email',
            'password',
            'client_id',
            'client_secret',
            'login_url',
            'result_url',
            'grant_type'
        ];
        $accessCredentials = [];

        foreach ($request->all() as $key => $value) {
            if (in_array($key, $fields)) {
                $accessCredentials[$key] = $value;
            }
        }

        $thirdPartyAccess = ThirdPartyAccess::updateOrCreate([
            'third_party_app_id' => $request->third_party_app_id,
        ], $accessCredentials);

        return response()->json($thirdPartyAccess);
    }

    /**
     * Destroy BLIS access to the third party application.
     *
     * @param  \App\ThirdPartyApp  $thirdPartyApp
     * @return \Illuminate\Http\Response
     */
    public function accessDestroy($id)
    {
        ThirdPartyAccess::destroy($id);

        return response()->json([], 200);
    }
}
