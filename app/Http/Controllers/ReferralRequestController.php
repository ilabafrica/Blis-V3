<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReferralRequest;

class ReferralRequestController extends Controller
{
	public function index()
	{
		$referralrequest=ReferralRequest::orderBy('id', 'ASC')->paginate(20);
		return response()->json(ReferralRequest);
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
		"type" => 'required',
		"requester" => 'required',
		"specialty" => 'required',
		"recipient" => 'required',

		);		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$referralrequest= new ReferralRequest;
			$referralrequest->based_on = $request->input('based_on');
			$referralrequest->replaces = $request->input('replaces');
			$referralrequest->group_identifier = $request->input('group_identifier');
			$referralrequest->status = $request->input('status');
			$referralrequest->type = $request->input('type');
			$referralrequest->priority = $request->input('priority');
			$referralrequest->service_requested = $request->input('service_requested');
			$referralrequest->subject = $request->input('subject');
			$referralrequest->occurence = $request->input('occurence');
			$referralrequest->requester = $request->input('requester');
			$referralrequest->specialty = $request->input('specialty');
			$referralrequest->recipient = $request->input('recipient');
			$referralrequest->reason_code = $request->input('reason_code');
			$referralrequest->reason_reference = $request->input('reason_reference');
			$referralrequest->supporting_info = $request->input('supporting_info');
			$referralrequest->description = $request->input('description');
			$referralrequest->note = $request->input('note');

			try{
				$referralrequest->save();
				return response()->json($referralrequest);
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
		$referralrequest=ReferralRequest::findorfails($id);
		return response()->json($referralrequest);
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
		"type" => 'required',
		"requester" => 'required',
		"specialty" => 'required',
		"recipient" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$referralrequest=ReferralRequest::findorfail($id);
			$referralrequest->based_on = $request->input('based_on');
			$referralrequest->replaces = $request->input('replaces');
			$referralrequest->group_identifier = $request->input('group_identifier');
			$referralrequest->status = $request->input('status');
			$referralrequest->type = $request->input('type');
			$referralrequest->priority = $request->input('priority');
			$referralrequest->service_requested = $request->input('service_requested');
			$referralrequest->subject = $request->input('subject');
			$referralrequest->occurence = $request->input('occurence');
			$referralrequest->requester = $request->input('requester');
			$referralrequest->specialty = $request->input('specialty');
			$referralrequest->recipient = $request->input('recipient');
			$referralrequest->reason_code = $request->input('reason_code');
			$referralrequest->reason_reference = $request->input('reason_reference');
			$referralrequest->supporting_info = $request->input('supporting_info');
			$referralrequest->description = $request->input('description');
			$referralrequest->note = $request->input('note');

			try{
				$referralrequest->save();
				return response()->json($referralrequest);
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
			$referralrequest=ReferralRequest::findorfails($id);
			$referralrequest->delete();
			return response()->json($referralrequest,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}