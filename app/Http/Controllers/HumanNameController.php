<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HumanName;

class HumanNameController extends Controller
{
	public function index()
	{
		$humanname = HumanName::orderBy('id', 'ASC')->paginate(20);
		return response()->json($humanname);
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
		"created_by" => 'required',
		"use" => 'required',
		"text" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$humanname= new HumanName;
			$humanname->created_by = $request->input('created_by');
			$humanname->use = $request->input('use');
			$humanname->text = $request->input('text');
			$humanname->family = $request->input('family');
			$humanname->given = $request->input('given');
			$humanname->prefix = $request->input('prefix');
			$humanname->suffix = $request->input('suffix');
			$humanname->period = $request->input('period');

			try{
				$humanname->save();
				return response()->json($humanname);
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
		$humanname=HumanName::findorfail($id);
		return response()->json($humanname);
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
		"created_by" => 'required',
		"use" => 'required',
		"text" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$humanname=HumanName::findorfail($id);
			$humanname->created_by = $request->input('created_by');
			$humanname->use = $request->input('use');
			$humanname->text = $request->input('text');
			$humanname->family = $request->input('family');
			$humanname->given = $request->input('given');
			$humanname->prefix = $request->input('prefix');
			$humanname->suffix = $request->input('suffix');
			$humanname->period = $request->input('period');

			try{
				$humanname->save();
				return response()->json($humanname);
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
			$humanname=HumanName::findorfail($id);
			$humanname->delete();
			return response()->json($humanname,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}