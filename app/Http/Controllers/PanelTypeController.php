<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PanelType;

class PanelTypeController extends Controller
{
	public function index()
	{
		$paneltype = PanelType::orderBy('id', 'ASC')->paginate(20);
		return response()->json($paneltype);
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
		"code_id" => 'required',
		"status_id" => 'required',
		"category_id" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$paneltype= new PanelType;
			$paneltype->code_id = $request->input('code_id');
			$paneltype->status_id = $request->input('status_id');
			$paneltype->category_id = $request->input('category_id');

			try{
				$paneltype->save();
				return response()->json($paneltype);
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
		$paneltype=PanelType::findorfails($id);
		return response()->json($paneltype);
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
		"code_id" => 'required',
		"status_id" => 'required',
		"category_id" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$paneltype=PanelType::findorfail($id);
			$paneltype->code_id = $request->input('code_id');
			$paneltype->status_id = $request->input('status_id');
			$paneltype->category_id = $request->input('category_id');

			try{
				$paneltype->save();
				return response()->json($paneltype);
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
			$paneltype=PanelType::findorfails($id);
			$paneltype->delete();
			return response()->json($paneltype,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}