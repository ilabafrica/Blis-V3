<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Container;

class ContainerController extends Controller
{
	public function index()
	{
		$container = Container::orderBy('id', 'ASC')->paginate(20);
		return response()->json($container);
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
		"description" => 'required',
		"type" => 'required',
		"capacity" => 'required',
		"quantity_id" => 'required',
		"additive" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$container= new Container;
			$container->description = $request->input('description');
			$container->type = $request->input('type');
			$container->capacity = $request->input('capacity');
			$container->quantity_id = $request->input('quantity_id');
			$container->additive = $request->input('additive');

			try{
				$container->save();
				return response()->json($container);
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
		$container=Container::findorfail($id);
		return response()->json($container);
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
		"description" => 'required',
		"type" => 'required',
		"capacity" => 'required',
		"quantity_id" => 'required',
		"additive" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$container=Container::findorfail($id);
			$container->description = $request->input('description');
			$container->type = $request->input('type');
			$container->capacity = $request->input('capacity');
			$container->quantity_id = $request->input('quantity_id');
			$container->additive = $request->input('additive');

			try{
				$container->save();
				return response()->json($container);
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
			$container=Container::findorfail($id);
			$container->delete();
			return response()->json($container,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}