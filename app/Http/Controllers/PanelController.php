<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panel;

class PanelController extends Controller
{
	public function index()
	{
		$panel = Panel::orderBy('id', 'ASC')->paginate(20);
		return response()->json($panel);
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
		"panel_type_id" => 'required',
		"performed_by" => 'required',
		"specimen_id" => 'required',
		"conclusion" => 'required',
		"coded_diagnosis" => 'required',
		"status_id" => 'required',
		"sort_order" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$panel= new Panel;
			$panel->panel_type_id = $request->input('panel_type_id');
			$panel->performed_by = $request->input('performed_by');
			$panel->specimen_id = $request->input('specimen_id');
			$panel->conclusion = $request->input('conclusion');
			$panel->coded_diagnosis = $request->input('coded_diagnosis');
			$panel->status_id = $request->input('status_id');
			$panel->sort_order = $request->input('sort_order');

			try{
				$panel->save();
				return response()->json($panel);
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
		$panel=Panel::findorfail($id);
		return response()->json($panel);
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
		"panel_type_id" => 'required',
		"performed_by" => 'required',
		"specimen_id" => 'required',
		"conclusion" => 'required',
		"coded_diagnosis" => 'required',
		"status_id" => 'required',
		"sort_order" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$panel=Panel::findorfail($id);
			$panel->panel_type_id = $request->input('panel_type_id');
			$panel->performed_by = $request->input('performed_by');
			$panel->specimen_id = $request->input('specimen_id');
			$panel->conclusion = $request->input('conclusion');
			$panel->coded_diagnosis = $request->input('coded_diagnosis');
			$panel->status_id = $request->input('status_id');
			$panel->sort_order = $request->input('sort_order');

			try{
				$panel->save();
				return response()->json($panel);
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
			$panel=Panel::findorfail($id);
			$panel->delete();
			return response()->json($panel,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}