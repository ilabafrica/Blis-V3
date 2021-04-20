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
