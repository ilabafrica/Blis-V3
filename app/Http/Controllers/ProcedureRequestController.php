<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcedureRequest;

class ProcedureRequestController extends Controller
{
	public function index()
	{
		$procedurerequest = ProcedureRequest::orderBy('id', 'ASC')->paginate(20);
		return response()->json($procedurerequest);
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
		"intent" => 'required',
		"priority" => 'required',
		"do_not_perform" => 'required',
		"category" => 'required',
		"code" => 'required',
		"subject" => 'required',
		"context" => 'required',
		"occurence" => 'required',
		"asneeded" => 'required',
		"authored_on" => 'required',
		"requester" => 'required',
		"performer_type" => 'required',
		"performer" => 'required',
		"body_site" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$procedurerequest= new ProcedureRequest;
			$procedurerequest->definition_id = $request->input('definition_id');
			$procedurerequest->based_on = $request->input('based_on');
			$procedurerequest->replaces = $request->input('replaces');
			$procedurerequest->requisition = $request->input('requisition');
			$procedurerequest->status = $request->input('status');
			$procedurerequest->intent = $request->input('intent');
			$procedurerequest->priority = $request->input('priority');
			$procedurerequest->do_not_perform = $request->input('do_not_perform');
			$procedurerequest->category = $request->input('category');
			$procedurerequest->code = $request->input('code');
			$procedurerequest->subject = $request->input('subject');
			$procedurerequest->context = $request->input('context');
			$procedurerequest->occurence = $request->input('occurence');
			$procedurerequest->asneeded = $request->input('asneeded');
			$procedurerequest->authored_on = $request->input('authored_on');
			$procedurerequest->requester = $request->input('requester');
			$procedurerequest->performer_type = $request->input('performer_type');
			$procedurerequest->performer = $request->input('performer');
			$procedurerequest->reason_code = $request->input('reason_code');
			$procedurerequest->reason_reference = $request->input('reason_reference');
			$procedurerequest->supporting_info = $request->input('supporting_info');
			$procedurerequest->specimen = $request->input('specimen');
			$procedurerequest->body_site = $request->input('body_site');
			$procedurerequest->note = $request->input('note');
			$procedurerequest->relevant_history = $request->input('relevant_history');

			try{
				$procedurerequest->save();
				return response()->json($procedurerequest);
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
    	try{
		$procedurerequest=ProcedureRequest::findorfail($id);
		return response()->json($procedurerequest);
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
		"status" => 'required',
		"intent" => 'required',
		"priority" => 'required',
		"do_not_perform" => 'required',
		"category" => 'required',
		"code" => 'required',
		"subject" => 'required',
		"context" => 'required',
		"occurence" => 'required',
		"asneeded" => 'required',
		"authored_on" => 'required',
		"requester" => 'required',
		"performer_type" => 'required',
		"performer" => 'required',
		"body_site" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$procedurerequest=ProcedureRequest::findorfail($id);
			$procedurerequest->definition_id = $request->input('definition_id');
			$procedurerequest->based_on = $request->input('based_on');
			$procedurerequest->replaces = $request->input('replaces');
			$procedurerequest->requisition = $request->input('requisition');
			$procedurerequest->status = $request->input('status');
			$procedurerequest->intent = $request->input('intent');
			$procedurerequest->priority = $request->input('priority');
			$procedurerequest->do_not_perform = $request->input('do_not_perform');
			$procedurerequest->category = $request->input('category');
			$procedurerequest->code = $request->input('code');
			$procedurerequest->subject = $request->input('subject');
			$procedurerequest->context = $request->input('context');
			$procedurerequest->occurence = $request->input('occurence');
			$procedurerequest->asneeded = $request->input('asneeded');
			$procedurerequest->authored_on = $request->input('authored_on');
			$procedurerequest->requester = $request->input('requester');
			$procedurerequest->performer_type = $request->input('performer_type');
			$procedurerequest->performer = $request->input('performer');
			$procedurerequest->reason_code = $request->input('reason_code');
			$procedurerequest->reason_reference = $request->input('reason_reference');
			$procedurerequest->supporting_info = $request->input('supporting_info');
			$procedurerequest->specimen = $request->input('specimen');
			$procedurerequest->body_site = $request->input('body_site');
			$procedurerequest->note = $request->input('note');
			$procedurerequest->relevant_history = $request->input('relevant_history');

			try{
				$procedurerequest->save();
				return response()->json($procedurerequest);
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
			$procedurerequest=ProcedureRequest::findorfail($id);
			$procedurerequest->delete();
			return response()->json($procedurerequest,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
		catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return response()->json( ['error' => 'Record not found' ], 404);
		}
	}
}