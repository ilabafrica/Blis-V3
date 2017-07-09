<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OauthPersonalAccessClient;

class OauthPersonalAccessClientController extends Controller
{
	public function index()
	{
		$oauthpersonalaccessclient = OauthPersonalAccessClient::orderBy('id', 'ASC')->paginate(20);
		return response()->json($oauthpersonalaccessclient);
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

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$oauthpersonalaccessclient= new OauthPersonalAccessClient;
			$oauthpersonalaccessclient->client_id = $request->input('client_id');

			try{
				$oauthpersonalaccessclient->save();
				return response()->json($oauthpersonalaccessclient);
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
		$oauthpersonalaccessclient=OauthPersonalAccessClient::findorfails($id);
		return response()->json($oauthpersonalaccessclient);
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

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$oauthpersonalaccessclient=OauthPersonalAccessClient::findorfail($id);
			$oauthpersonalaccessclient->client_id = $request->input('client_id');

			try{
				$oauthpersonalaccessclient->save();
				return response()->json($oauthpersonalaccessclient);
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
			$oauthpersonalaccessclient=OauthPersonalAccessClient::findorfails($id);
			$oauthpersonalaccessclient->delete();
			return response()->json($oauthpersonalaccessclient,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}