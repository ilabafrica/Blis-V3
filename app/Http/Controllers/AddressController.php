<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
	public function index()
	{
		$address = Address::orderBy('id', 'ASC')->paginate(20);
		return response()->json($address);
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
		"use" => 'required',
		"type" => 'required',
		"text" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$address= new Address;
			$address->use = $request->input('use');
			$address->type = $request->input('type');
			$address->text = $request->input('text');
			$address->line = $request->input('line');
			$address->city = $request->input('city');
			$address->district = $request->input('district');
			$address->state = $request->input('state');
			$address->postal_code = $request->input('postal_code');
			$address->country = $request->input('country');
			$address->period = $request->input('period');

			try{
				$address->save();
				return response()->json($address);
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
			$address=Address::findorfail($id);
			return response()->json($address);
		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
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
		"use" => 'required',
		"type" => 'required',
		"text" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$address=Address::findorfail($id);
			$address->use = $request->input('use');
			$address->type = $request->input('type');
			$address->text = $request->input('text');
			$address->line = $request->input('line');
			$address->city = $request->input('city');
			$address->district = $request->input('district');
			$address->state = $request->input('state');
			$address->postal_code = $request->input('postal_code');
			$address->country = $request->input('country');
			$address->period = $request->input('period');

			try{
				$address->save();
				return response()->json($address);
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
			$address=Address::findorfail($id);
			$address->delete();
			return response()->json($address,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
		catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return response()->json( ['error' => 'Record not found' ], 404);
		}
	}
}