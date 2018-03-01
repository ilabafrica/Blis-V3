<?php
namespace App\Http\Controllers;
/**
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use Illuminate\Http\Request;
use App\Models\Referral;

class ReferralController extends Controller
{
	public function index()
	{
		$referral=Referral::orderBy('id', 'ASC')->paginate(20);
		return response()->json($referral);
	}


	/**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request
    * @return \Illuminate\Http\Response
    */
	public function store(Request $request)
	{
		$rules = array(
			"storage_condition" => 'required',
			"transport_type" => 'required',
			"priority_specimen" => 'required',
			"organization_id" => 'required',
			"person" => 'required',
			"contacts" => 'required',
			"user_id" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator);
		} else {
			$referral= new Referral;
			$referral->time_dispatch = $request->input('time_dispatch');
			$referral->storage_condition = $request->input('storage_condition');
			$referral->transport_type = $request->input('transport_type');
			$referral->referral_reason_id = $request->input('referral_reason_id');
			$referral->priority_specimen = $request->input('priority_specimen');
			$referral->organization_id = $request->input('organization_id');
			$referral->person = $request->input('person');
			$referral->contacts = $request->input('contacts');
			$referral->user_id = $request->input('user_id');

			try{
				$referral->save();
				return response()->json($referral);
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
		$referral=Referral::findOrFail($id);
		return response()->json($referral);
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
			"storage_condition" => 'required',
			"transport_type" => 'required',
			"priority_specimen" => 'required',
			"organization_id" => 'required',
			"person" => 'required',
			"contacts" => 'required',
			"user_id" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			return response()->json($validator,422);
		} else {
			$referral=Referral::findOrFail($id);
			$referral->time_dispatch = $request->input('time_dispatch');
			$referral->storage_condition = $request->input('storage_condition');
			$referral->transport_type = $request->input('transport_type');
			$referral->referral_reason_id = $request->input('referral_reason_id');
			$referral->priority_specimen = $request->input('priority_specimen');
			$referral->organization_id = $request->input('organization_id');
			$referral->person = $request->input('person');
			$referral->contacts = $request->input('contacts');
			$referral->user_id = $request->input('user_id');

			try{
				$referral->save();
				return response()->json($referral);
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
			$referral=Referral::findOrFail($id);
			$referral->delete();
			return response()->json($referral,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}