<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coding;

class CodingController extends Controller
{
	public function index()
	{
		$coding = Coding::orderBy('id', 'ASC')->paginate(20);
		return response()->json($coding);
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
		"uri" => 'required',
		"version" => 'required',
		"code" => 'required',
		"display" => 'required',
		"userSelected" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$coding= new Coding;
			$coding->uri = $request->input('uri');
			$coding->version = $request->input('version');
			$coding->code = $request->input('code');
			$coding->display = $request->input('display');
			$coding->userSelected = $request->input('userSelected');

			try{
				$coding->save();
				return response()->json($coding);
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
		$coding=Coding::findorfail($id);
		return response()->json($coding);
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
		"uri" => 'required',
		"version" => 'required',
		"code" => 'required',
		"display" => 'required',
		"userSelected" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$coding=Coding::findorfail($id);
			$coding->uri = $request->input('uri');
			$coding->version = $request->input('version');
			$coding->code = $request->input('code');
			$coding->display = $request->input('display');
			$coding->userSelected = $request->input('userSelected');

			try{
				$coding->save();
				return response()->json($coding);
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
			$coding=Coding::findorfail($id);
			$coding->delete();
			return response()->json($coding,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}