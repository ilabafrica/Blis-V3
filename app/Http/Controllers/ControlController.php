<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Control;

class ControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $controls = Control::orderBy('id')->get();
        return response()->json($controls);
        
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
        $rules = array('name' => 'required|unique:controls,name,NULL,id,deleted_at,null',
                    'instrument_id' => 'required',
                    'new-measures' => 'required');
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json();
        } else {
            // Add
            $control = new Control;
            $control->name = Input::get('name');
            $control->description = Input::get('description');
            $control->instrument_id = Input::get('instrument_id');

            // if (Input::get('new-measures')) {
            //         $newMeasures = Input::get('new-measures');
            //         $controlMeasure = New ControlMeasureController;
            //         $controlMeasure->saveMeasuresRanges($newMeasures, $control);
            // }
            // redirect
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
        $rules = array(
            'name' => 'unique:controls,name,NULL,id,deleted_at,null',
            'instrument_id' => 'required',
            'measures' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return response()->json();
        } else {
            // Update
            $control = Control::find($id);
            $control->name = Input::get('name');
            $control->description = Input::get('description');
            $control->instrument_id = Input::get('instrument_id');

            // if (Input::get('new-measures')) {
            //     $inputNewMeasures = Input::get('new-measures');
            //     $measures = New ControlMeasureController;
            //     $measureIds = $measures->saveMeasuresRanges($inputNewMeasures, $control);
            // }

            // if (Input::get('measures')) {
            //     $inputMeasures = Input::get('measures');
            //     $measures = New ControlMeasureController;
            //     $measures->editMeasuresRanges($inputMeasures, $control);
            // }
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
        $control = Control::find($id);
        $control->delete();
        
        return response()->json();
    }
}
