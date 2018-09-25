<?php

namespace App\Http\Controllers;

use Auth;
use App\ThirdPartyApp;
use Illuminate\Http\Request;

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
}
