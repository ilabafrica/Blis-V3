<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;

class PasswordResetController extends Controller
{
	public function index()
	{
		$passwordreset = PasswordReset::orderBy('id', 'ASC')->paginate(20);
		return response()->json($passwordreset);
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
		"email" => 'required',
		"token" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$passwordreset= new PasswordReset;
			$passwordreset->email = $request->input('email');
			$passwordreset->token = $request->input('token');

			try{
				$passwordreset->save();
				return response()->json($passwordreset);
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
		$passwordreset=PasswordReset::findorfails($id);
		return response()->json($passwordreset);
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
		"email" => 'required',
		"token" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$passwordreset=PasswordReset::findorfail($id);
			$passwordreset->email = $request->input('email');
			$passwordreset->token = $request->input('token');

			try{
				$passwordreset->save();
				return response()->json($passwordreset);
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
			$passwordreset=PasswordReset::findorfails($id);
			$passwordreset->delete();
			return response()->json($passwordreset,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}