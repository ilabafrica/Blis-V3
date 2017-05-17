<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Test as Test;
use App\Models\Testtype;
use App\Models\Visit;
use App\Models\Specimen;

use Input;
use Auth;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = Input::get('search');
        
        $tests = Test::search($search)->orderBy('id', 'desc')->paginate();

        return response()->json($tests);
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
       $rules = array(
            'visit_type' => 'required',
            'physician' => 'required',
            'testtypes' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {

        return response()->json();
        
        } else {

            $visitType = ['Out-patient','In-patient'];
            $activeTest = array();

            /*
            * - Create a visit
            * - Fields required: visit_type, patient_id
            */
            $visit = new Visit;
            $visit->patient_id = Input::get('patient_id');
            $visit->visit_type = $visitType[Input::get('visit_type')];
            $visit->save();

            /*
            * - Create tests requested
            * - Fields required: visit_id, test_type_id, specimen_id, test_status_id, created_by, requested_by
            */
            $testTypes = Input::get('testtypes');
            if(is_array($testTypes)){
                foreach ($testTypes as $value) {
                    $testTypeID = (int)$value;
                    // Create Specimen - specimen_type_id, accepted_by, referred_from, referred_to
                    $specimen = new Specimen;
                    $specimen->specimen_type_id = TestType::find($testTypeID)->specimenTypes->lists('id')[0];
                    $specimen->accepted_by = Auth::user()->id;
                    $specimen->save();

                    $test = new Test;
                    $test->visit_id = $visit->id;
                    $test->test_type_id = $testTypeID;
                    $test->specimen_id = $specimen->id;
                    $test->test_status_id = Test::PENDING;
                    $test->created_by = Auth::user()->id;
                    $test->requested_by = Input::get('physician');
                    $test->save();

                    $activeTest[] = $test->id;
                }
            }

            return response()->json();
           
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
