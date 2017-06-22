<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserType;

class UserTypeController extends Controller
{
	public function index()
	{
		$usertype=UserType::orderBy('id', 'ASC')->paginate(20);
		return response()->json(UserType);
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
		"description" => 'required',

		);		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$usertype= new UserType;
			$usertype->name = $request->input('name');
			$usertype->description = $request->input('description');

			try{
				$usertype->save();
				return response()->json($usertype);
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
		$usertype=UserType::findorfails($id);
		return response()->json($usertype);
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
		"description" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$usertype=UserType::findorfail($id);
			$usertype->name = $request->input('name');
			$usertype->description = $request->input('description');

			try{
				$usertype->save();
				return response()->json($usertype);
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
			$usertype=UserType::findorfails($id);
			$usertype->delete();
			return response()->json($usertype,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}