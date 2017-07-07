<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
	public function index()
	{
		$user=User::orderBy('id', 'ASC')->paginate(20);
		return response()->json($user);
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
		"type" => 'required',
		"email" => 'required',
		"password" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$user= new User;
			$user->type = $request->input('type');
			$user->email = $request->input('email');
			$user->password = $request->input('password');
			$user->remember_token = $request->input('remember_token');

			try{
				$user->save();
				return response()->json($user);
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
		$user=User::findorfails($id);
		return response()->json($user);
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
		"type" => 'required',
		"email" => 'required',
		"password" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$user=User::findorfail($id);
			$user->type = $request->input('type');
			$user->email = $request->input('email');
			$user->password = $request->input('password');
			$user->remember_token = $request->input('remember_token');

			try{
				$user->save();
				return response()->json($user);
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
			$user=User::findorfails($id);
			$user->delete();
			return response()->json($user,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}