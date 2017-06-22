<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quantity;

class QuantityController extends Controller
{
	public function index()
	{
		$quantity=Quantity::orderBy('id', 'ASC')->paginate(20);
		return response()->json(Quantity);
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
		"value" => 'required',
		"unit" => 'required',

		);		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$quantity= new Quantity;
			$quantity->value = $request->input('value');
			$quantity->comparator = $request->input('comparator');
			$quantity->unit = $request->input('unit');
			$quantity->system = $request->input('system');
			$quantity->code = $request->input('code');

			try{
				$quantity->save();
				return response()->json($quantity);
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
		$quantity=Quantity::findorfails($id);
		return response()->json($quantity);
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
		"value" => 'required',
		"unit" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$quantity=Quantity::findorfail($id);
			$quantity->value = $request->input('value');
			$quantity->comparator = $request->input('comparator');
			$quantity->unit = $request->input('unit');
			$quantity->system = $request->input('system');
			$quantity->code = $request->input('code');

			try{
				$quantity->save();
				return response()->json($quantity);
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
			$quantity=Quantity::findorfails($id);
			$quantity->delete();
			return response()->json($quantity,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}