<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Practitioner;

class PractitionerController extends Controller
{
	public function index()
	{
		$practitioner = Practitioner::orderBy('id', 'ASC')->paginate(20);
		return response()->json($practitioner);
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
		"active" => 'required',
		"user_id" => 'required',
		"name" => 'required',
		"telecom" => 'required',
		"gender" => 'required',
		"birth_date" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$practitioner= new Practitioner;
			$practitioner->active = $request->input('active');
			$practitioner->user_id = $request->input('user_id');
			$practitioner->name = $request->input('name');
			$practitioner->telecom = $request->input('telecom');
			$practitioner->address = $request->input('address');
			$practitioner->gender = $request->input('gender');
			$practitioner->birth_date = $request->input('birth_date');
			$practitioner->photo = $request->input('photo');

			try{
				$practitioner->save();
				return response()->json($practitioner);
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
		$practitioner=Practitioner::findorfails($id);
		return response()->json($practitioner);
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
		"active" => 'required',
		"user_id" => 'required',
		"name" => 'required',
		"telecom" => 'required',
		"gender" => 'required',
		"birth_date" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$practitioner=Practitioner::findorfail($id);
			$practitioner->active = $request->input('active');
			$practitioner->user_id = $request->input('user_id');
			$practitioner->name = $request->input('name');
			$practitioner->telecom = $request->input('telecom');
			$practitioner->address = $request->input('address');
			$practitioner->gender = $request->input('gender');
			$practitioner->birth_date = $request->input('birth_date');
			$practitioner->photo = $request->input('photo');

			try{
				$practitioner->save();
				return response()->json($practitioner);
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
			$practitioner=Practitioner::findorfails($id);
			$practitioner->delete();
			return response()->json($practitioner,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}