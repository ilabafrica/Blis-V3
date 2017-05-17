<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class CriticalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $criticals = Critical::orderBy('id', 'ASC')->get();
        return response()->json($criticals);
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
        //Validation
        $rules = array('measure_id' => 'required:critical,parameter');
        $validator = Validator::make(Input::all(), $rules);
    
        //process
        if($validator->fails()){
            return response()->json();
        }else{
            //store
            $critical = new Critical;
            $critical->parameter = Input::get('measure_id');
            $critical->gender = Input::get('gender');
            $critical->age_min = Input::get('age_min');
            $critical->age_max = Input::get('age_max');
            $critical->normal_lower = Input::get('normal_lower');
            $critical->normal_upper = Input::get('normal_upper');
            $critical->critical_low = Input::get('critical_low');
            $critical->critical_high = Input::get('critical_high');
            $critical->unit = Input::get('unit');
            $critical->save();
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
        $critical = Critical::find($id);
        return response()->json($critical);  
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
        //Validate
        $rules = array('measure_id' => 'required');
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return response()->json();  
        } else {
            // Update
            $critical = Critical::find($id);
            $critical->parameter = Input::get('measure_id');
            $critical->gender = Input::get('gender');
            $critical->age_min = Input::get('age_min');
            $critical->age_max = Input::get('age_max');
            $critical->normal_lower = Input::get('normal_lower');
            $critical->normal_upper = Input::get('normal_upper');
            $critical->critical_low = Input::get('critical_low');
            $critical->critical_high = Input::get('critical_high');
            $critical->unit = Input::get('unit');
            $critical->save();

            // redirect
            return response()->json();  
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $critical = Critical::find($id);
        $critical->delete();

        return response()->json();  
        
    }
}
