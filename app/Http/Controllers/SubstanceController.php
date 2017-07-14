<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Substance;

class SubstanceController extends Controller
{
	public function index()
	{
		$substance = Substance::orderBy('id', 'ASC')->paginate(20);
		return response()->json($substance);
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
		"status" => 'required',
		"category" => 'required',
		"code" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$substance= new Substance;
			$substance->status = $request->input('status');
			$substance->category = $request->input('category');
			$substance->code = $request->input('code');
			$substance->description = $request->input('description');

			try{
				$substance->save();
				return response()->json($substance);
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
		$substance=Substance::findorfail($id);
		return response()->json($substance);
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
		"status" => 'required',
		"category" => 'required',
		"code" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$substance=Substance::findorfail($id);
			$substance->status = $request->input('status');
			$substance->category = $request->input('category');
			$substance->code = $request->input('code');
			$substance->description = $request->input('description');

			try{
				$substance->save();
				return response()->json($substance);
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
			$substance=Substance::findorfail($id);
			$substance->delete();
			return response()->json($substance,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}