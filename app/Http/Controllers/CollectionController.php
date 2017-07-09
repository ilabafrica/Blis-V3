<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;

class CollectionController extends Controller
{
	public function index()
	{
		$collection = Collection::orderBy('id', 'ASC')->paginate(20);
		return response()->json($collection);
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
		"collector" => 'required',
		"collection_time" => 'required',
		"quantity_id" => 'required',
		"method" => 'required',
		"body_site" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$collection= new Collection;
			$collection->collector = $request->input('collector');
			$collection->collection_time = $request->input('collection_time');
			$collection->quantity_id = $request->input('quantity_id');
			$collection->method = $request->input('method');
			$collection->body_site = $request->input('body_site');

			try{
				$collection->save();
				return response()->json($collection);
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
		$collection=Collection::findorfails($id);
		return response()->json($collection);
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
		"collector" => 'required',
		"collection_time" => 'required',
		"quantity_id" => 'required',
		"method" => 'required',
		"body_site" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$collection=Collection::findorfail($id);
			$collection->collector = $request->input('collector');
			$collection->collection_time = $request->input('collection_time');
			$collection->quantity_id = $request->input('quantity_id');
			$collection->method = $request->input('method');
			$collection->body_site = $request->input('body_site');

			try{
				$collection->save();
				return response()->json($collection);
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
			$collection=Collection::findorfails($id);
			$collection->delete();
			return response()->json($collection,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}