<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientController extends Controller
{
	public function index()
	{
		$ingredient=Ingredient::orderBy('id', 'ASC')->paginate(20);
		return response()->json(Ingredient);
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

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$ingredient= new Ingredient;
			$ingredient->quantity = $request->input('quantity');
			$ingredient->substance = $request->input('substance');

			try{
				$ingredient->save();
				return response()->json($ingredient);
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
		$ingredient=Ingredient::findorfails($id);
		return response()->json($ingredient);
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

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$ingredient=Ingredient::findorfail($id);
			$ingredient->quantity = $request->input('quantity');
			$ingredient->substance = $request->input('substance');

			try{
				$ingredient->save();
				return response()->json($ingredient);
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
			$ingredient=Ingredient::findorfails($id);
			$ingredient->delete();
			return response()->json($ingredient,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}