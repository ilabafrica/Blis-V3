<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizationContact;

class OrganizationContactController extends Controller
{
	public function index()
	{
		$organizationcontact=OrganizationContact::orderBy('id', 'ASC')->paginate(20);
		return response()->json(OrganizationContact);
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
		"organization_id" => 'required',
		"purpose" => 'required',
		"name" => 'required',
		"telecom" => 'required',

		);
		$validator = \Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			 return response()->json($validator);
		} else {
			$organizationcontact= new OrganizationContact;
			$organizationcontact->organization_id = $request->input('organization_id');
			$organizationcontact->purpose = $request->input('purpose');
			$organizationcontact->name = $request->input('name');
			$organizationcontact->telecom = $request->input('telecom');
			$organizationcontact->address = $request->input('address');

			try{
				$organizationcontact->save();
				return response()->json($organizationcontact);
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
		$organizationcontact=OrganizationContact::findorfails($id);
		return response()->json($organizationcontact);
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
		"organization_id" => 'required',
		"purpose" => 'required',
		"name" => 'required',
		"telecom" => 'required',

		);
        $validator = \Validator::make($request->all(),$rules);
		 if ($validator->fails()) {
			 return response()->json($validator,422);
		} else {
			$organizationcontact=OrganizationContact::findorfail($id);
			$organizationcontact->organization_id = $request->input('organization_id');
			$organizationcontact->purpose = $request->input('purpose');
			$organizationcontact->name = $request->input('name');
			$organizationcontact->telecom = $request->input('telecom');
			$organizationcontact->address = $request->input('address');

			try{
				$organizationcontact->save();
				return response()->json($organizationcontact);
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
			$organizationcontact=OrganizationContact::findorfails($id);
			$organizationcontact->delete();
			return response()->json($organizationcontact,200);
		}
		catch (\Illuminate\Database\QueryException $e){
			return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}
}