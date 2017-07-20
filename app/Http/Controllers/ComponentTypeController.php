<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComponentType;

class ComponentTypeController extends Controller
{
	public function index()
	{
		$componenttype = ComponentType::orderBy('id', 'ASC')->paginate(20);
		return response()->json($componenttype);
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
		"result_type_id" => 'required',
		"reference_range_id" => 'required',
		"parent_id" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$componenttype= new ComponentType;
			$componenttype->code_id = $request->input('code_id');
			$componenttype->result_type_id = $request->input('result_type_id');
			$componenttype->reference_range_id = $request->input('reference_range_id');
			$componenttype->parent_id = $request->input('parent_id');

			try{
				$componenttype->save();
				return response()->json($componenttype);
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
     */
    public function show($id){
    	try {
		$componenttype=ComponentType::findorfail($id);
		return response()->json($componenttype);
	}
	catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return response()->json( ['error' => 'Record not found' ], 404);
		}
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
		"result_type_id" => 'required',
		"reference_range_id" => 'required',
		"parent_id" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$componenttype=ComponentType::findorfail($id);
			$componenttype->code_id = $request->input('code_id');
			$componenttype->result_type_id = $request->input('result_type_id');
			$componenttype->reference_range_id = $request->input('reference_range_id');
			$componenttype->parent_id = $request->input('parent_id');

			try{
				$componenttype->save();
				return response()->json($componenttype);
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
			$componenttype=ComponentType::findorfail($id);
			$componenttype->delete();
			return response()->json($componenttype,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
		catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return response()->json( ['error' => 'Record not found' ], 404);
		}
	}
}