<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OauthAuthCode;

class OauthAuthCodeController extends Controller
{
	public function index()
	{
		$oauthauthcode=OauthAuthCode::orderBy('id', 'ASC')->paginate(20);
		return response()->json(OauthAuthCode);
	}


    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request
    * @return \Illuminate\Http\Response
    */
	public function store(Request $request)
	{
        $rules=array(
		"user_id" => 'required',
		"client_id" => 'required',
		"revoked" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$oauthauthcode= new OauthAuthCode;
			$oauthauthcode->user_id = $request->input('user_id');
			$oauthauthcode->client_id = $request->input('client_id');
			$oauthauthcode->scopes = $request->input('scopes');
			$oauthauthcode->revoked = $request->input('revoked');
			$oauthauthcode->expires_at = $request->input('expires_at');

			try{
				$oauthauthcode->save();
				return response()->json($oauthauthcode);
			}
			catch (\Illuminate\Database\QueryException $e){
				return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
			}
		}
	}

    /**
     * Display the specified resource.
     *
     * @param  int  id
     * @return \Illuminate\Http\Response
     */public function show($id){
		$oauthauthcode=OauthAuthCode::findorfails($id);
		return response()->json($oauthauthcode);
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
    
        $rules=array(
		"user_id" => 'required',
		"client_id" => 'required',
		"revoked" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$oauthauthcode=OauthAuthCode::findorfail($id);
			$oauthauthcode->user_id = $request->input('user_id');
			$oauthauthcode->client_id = $request->input('client_id');
			$oauthauthcode->scopes = $request->input('scopes');
			$oauthauthcode->revoked = $request->input('revoked');
			$oauthauthcode->expires_at = $request->input('expires_at');

			try{
				$oauthauthcode->save();
				return response()->json($oauthauthcode);
			}
			catch (\Illuminate\Database\QueryException $e){
				return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
			}
		}
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  id
     * @return \Illuminate\Http\Response
     */
	public function destroy($id){
		try{
			$oauthauthcode=OauthAuthCode::findorfails($id);
			$oauthauthcode->delete();
			return response()->json($oauthauthcode,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}