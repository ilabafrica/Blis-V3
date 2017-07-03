<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OauthAccessToken;

class OauthAccessTokenController extends Controller
{
	public function index()
	{
		$oauthaccesstoken=OauthAccessToken::orderBy('id', 'ASC')->paginate(20);
		return response()->json(OauthAccessToken);
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
		"client_id" => 'required',
		"revoked" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$oauthaccesstoken= new OauthAccessToken;
			$oauthaccesstoken->user_id = $request->input('user_id');
			$oauthaccesstoken->client_id = $request->input('client_id');
			$oauthaccesstoken->name = $request->input('name');
			$oauthaccesstoken->scopes = $request->input('scopes');
			$oauthaccesstoken->revoked = $request->input('revoked');
			$oauthaccesstoken->expires_at = $request->input('expires_at');

			try{
				$oauthaccesstoken->save();
				return response()->json($oauthaccesstoken);
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
		$oauthaccesstoken=OauthAccessToken::findorfails($id);
		return response()->json($oauthaccesstoken);
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
		"client_id" => 'required',
		"revoked" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$oauthaccesstoken=OauthAccessToken::findorfail($id);
			$oauthaccesstoken->user_id = $request->input('user_id');
			$oauthaccesstoken->client_id = $request->input('client_id');
			$oauthaccesstoken->name = $request->input('name');
			$oauthaccesstoken->scopes = $request->input('scopes');
			$oauthaccesstoken->revoked = $request->input('revoked');
			$oauthaccesstoken->expires_at = $request->input('expires_at');

			try{
				$oauthaccesstoken->save();
				return response()->json($oauthaccesstoken);
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
			$oauthaccesstoken=OauthAccessToken::findorfails($id);
			$oauthaccesstoken->delete();
			return response()->json($oauthaccesstoken,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}