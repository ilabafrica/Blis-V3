<?php

namespace App\Http\Controllers;

use Auth;
use App\ThirdPartyApp;
use Illuminate\Http\Request;
use App\Models\ThirdPartyAccess;

class ThirdPartyAppController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:tpa_api', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show(ThirdPartyApp $thirdPartyApp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ThirdPartyApp  $thirdPartyApp
     * @return \Illuminate\Http\Response
     */
    public function edit(ThirdPartyApp $thirdPartyApp)
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
    public function update(Request $request, ThirdPartyApp $thirdPartyApp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ThirdPartyApp  $thirdPartyApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThirdPartyApp $thirdPartyApp)
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
        $thirdPartyAccess = ThirdPartyAccess::updateOrCreate([
            'third_party_app_id' => $request->third_party_app_id,
        ], [
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'client_id' => $request->client_id,
            'client_secret' => $request->client_secret,
        ]);

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
