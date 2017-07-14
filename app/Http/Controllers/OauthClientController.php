<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OauthClient;

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
        $rules=array(
		"name" => 'required',
		"secret" => 'required',
		"redirect" => 'required',
		"personal_access_client" => 'required',
		"password_client" => 'required',
		"revoked" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$oauthclient= new OauthClient;
			$oauthclient->user_id = $request->input('user_id');
			$oauthclient->name = $request->input('name');
			$oauthclient->secret = $request->input('secret');
			$oauthclient->redirect = $request->input('redirect');
			$oauthclient->personal_access_client = $request->input('personal_access_client');
			$oauthclient->password_client = $request->input('password_client');
			$oauthclient->revoked = $request->input('revoked');

			try{
				$oauthclient->save();
				return response()->json($oauthclient);
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
		$oauthclient=OauthClient::findorfail($id);
		return response()->json($oauthclient);
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
		"name" => 'required',
		"secret" => 'required',
		"redirect" => 'required',
		"personal_access_client" => 'required',
		"password_client" => 'required',
		"revoked" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$oauthclient=OauthClient::findorfail($id);
			$oauthclient->user_id = $request->input('user_id');
			$oauthclient->name = $request->input('name');
			$oauthclient->secret = $request->input('secret');
			$oauthclient->redirect = $request->input('redirect');
			$oauthclient->personal_access_client = $request->input('personal_access_client');
			$oauthclient->password_client = $request->input('password_client');
			$oauthclient->revoked = $request->input('revoked');

			try{
				$oauthclient->save();
				return response()->json($oauthclient);
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
			$oauthclient=OauthClient::findorfail($id);
			$oauthclient->delete();
			return response()->json($oauthclient,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}