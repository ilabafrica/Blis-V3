<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReferenceRange;

class ReferenceRangeController extends Controller
{
	public function index()
	{
		$referencerange = ReferenceRange::orderBy('id', 'ASC')->paginate(20);
		return response()->json($referencerange);
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
		"low_normal" => 'required',
		"high_normal" => 'required',
		"low_critical" => 'required',
		"high_critical" => 'required',
		"age_min" => 'required',
		"age_max" => 'required',
		"age_type" => 'required',
		"applies_to" => 'required',
		"text" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$referencerange= new ReferenceRange;
			$referencerange->low_normal = $request->input('low_normal');
			$referencerange->high_normal = $request->input('high_normal');
			$referencerange->low_critical = $request->input('low_critical');
			$referencerange->high_critical = $request->input('high_critical');
			$referencerange->age_min = $request->input('age_min');
			$referencerange->age_max = $request->input('age_max');
			$referencerange->age_type = $request->input('age_type');
			$referencerange->applies_to = $request->input('applies_to');
			$referencerange->text = $request->input('text');

			try{
				$referencerange->save();
				return response()->json($referencerange);
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
		$referencerange=ReferenceRange::findorfails($id);
		return response()->json($referencerange);
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
		"low_normal" => 'required',
		"high_normal" => 'required',
		"low_critical" => 'required',
		"high_critical" => 'required',
		"age_min" => 'required',
		"age_max" => 'required',
		"age_type" => 'required',
		"applies_to" => 'required',
		"text" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$referencerange=ReferenceRange::findorfail($id);
			$referencerange->low_normal = $request->input('low_normal');
			$referencerange->high_normal = $request->input('high_normal');
			$referencerange->low_critical = $request->input('low_critical');
			$referencerange->high_critical = $request->input('high_critical');
			$referencerange->age_min = $request->input('age_min');
			$referencerange->age_max = $request->input('age_max');
			$referencerange->age_type = $request->input('age_type');
			$referencerange->applies_to = $request->input('applies_to');
			$referencerange->text = $request->input('text');

			try{
				$referencerange->save();
				return response()->json($referencerange);
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
			$referencerange=ReferenceRange::findorfails($id);
			$referencerange->delete();
			return response()->json($referencerange,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}