<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CodeableConcept;

class CodeableConceptController extends Controller
{
	public function index()
	{
		$codeableconcept=CodeableConcept::orderBy('id', 'ASC')->paginate(20);
		return response()->json(CodeableConcept);
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
		"code" => 'required',
		"description" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$codeableconcept= new CodeableConcept;
			$codeableconcept->code = $request->input('code');
			$codeableconcept->description = $request->input('description');

			try{
				$codeableconcept->save();
				return response()->json($codeableconcept);
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
		$codeableconcept=CodeableConcept::findorfails($id);
		return response()->json($codeableconcept);
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
		"code" => 'required',
		"description" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$codeableconcept=CodeableConcept::findorfail($id);
			$codeableconcept->code = $request->input('code');
			$codeableconcept->description = $request->input('description');

			try{
				$codeableconcept->save();
				return response()->json($codeableconcept);
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
			$codeableconcept=CodeableConcept::findorfails($id);
			$codeableconcept->delete();
			return response()->json($codeableconcept,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}