<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Name;
use App\Models\Test;
use App\Models\Gender;
use App\Models\Patient;
use App\Models\TestType;
use App\Models\Encounter;
use App\ThirdPartyApp;
use Illuminate\Http\Request;
use App\Models\TestTypeCategory;

class ThirdPartyAppController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:tpa_api', ['except' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    // return test menu
    public function testMenu()
    {
        $testTypes = TestTypeCategory::with('testTypes')->get();

        return response()->json($testTypes);
    }
    // receive and add test request on queue
    public function receiveTestRequest(Request $request)
    {
        $rules = [
            'subject' => 'required',
            'orderer' => 'required',
            'item' => 'required',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            try {

                $patient = Patient::where('identifier',$request->input('subject.identifier'));

                // if patient exists
                if ($patient->count()) {
                    $patient = $patient->first();

                }else{
                    // create patient entry
                    $name = new Name;
                    $name->text = $request->input('subject.name');
                    $name->save();

                    // male | female | other | unknown
                    $gender = new Gender;
                    $gender->code = $request->input('subject.gender');
                    $gender->display = ucfirst($request->input('subject.gender'));
                    $gender->save();

                    // save subject in patient
                    $patient = new Patient;
                    $patient->identifier = $request->input('subject.identifier');
                    $patient->name_id = $name->id;
                    $patient->gender_id = $gender->id;
                    $patient->birth_date = $request->input('subject.birthDate');
                    $patient->created_by = Auth::guard('tpa_api')->user()->id;
                    $patient->save();
                }

                // on the lab side, assuming each set of requests represent an encounter
                $encounter = new Encounter;
                $encounter->identifier = $request->input('subject.identifier');
                $encounter->patient_id = $patient->id;
                $encounter->location_id = $request->input('location_id');
                $encounter->practitioner_name = $request->input('orderer.name');
                $encounter->practitioner_contact = $request->input('orderer.contact');
                $encounter->practitioner_organisation = $request->input('orderer.organisation');
                $encounter->save();

                // recode each item in DiagnosticOrder to keep track of what has happened to it
                foreach ($request->input('item') as $item) {

                    // save order items in tests
                    $test = new Test;
                    $test->encounter_id = $encounter->id;
                    $test->identifier = $request->input('subject.identifier');// using patient for now
                    $test->test_type_id = $item['test_type_id'];
                    $test->test_status_id = TestStatus::pending;
                    $test->created_by = Auth::guard('tpa_api')->user()->id;
                    $test->requested_by = $request->input('orderer.name');// practitioner
                    $test->save();

                    $diagnosticOrder = new DiagnosticOrder;
                    $diagnosticOrder->test_id = $test->id;
                    $diagnosticOrder->save();
                }

                return response()->json(['message' => 'Test Request Received']);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ThirdPartyApp  $thirdPartyApp
     * @return \Illuminate\Http\Response
     */
    public function show(ThirdPartyApp $thirdPartyApp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ThirdPartyApp  $thirdPartyApp
     * @return \Illuminate\Http\Response
     */
    public function edit(ThirdPartyApp $thirdPartyApp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ThirdPartyApp  $thirdPartyApp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThirdPartyApp $thirdPartyApp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ThirdPartyApp  $thirdPartyApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThirdPartyApp $thirdPartyApp)
    {
        //
    }
}
