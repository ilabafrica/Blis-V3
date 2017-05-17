<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drug;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drugs = Drug::orderBy('name', 'ASC')->get();
        return response()->json($drugs);        
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
        $rules = array('name' => 'required|unique:drugs,name');
        $rules = array('abbreviation' => 'required|unique:drugs,abbreviation');
        $validator = Validator::make(Input::all(), $rules);
    
        //process
        if($validator->fails()){
            return response()->json();
        }else{
            //store
            $drug = new Drug;
            $drug->name = Input::get('name');
            $drug->abbreviation = Input::get('abbreviation');
            $drug->description = Input::get('description');
            $drug->save();

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
        $drug = Drug::find($id);
        return response()->json($drug);            
        
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
        $rules = array('name' => 'required');
        $rules = array('abbreviation' => 'required|unique:drugs,abbreviation');
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return response()->json();            
        } else {
            // Update
            $drug = Drug::find($id);
            $drug->name = Input::get('name');
            $drug->abbreviation = Input::get('abbreviation');
            $drug->description = Input::get('description');
            $drug->save();

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
        $drug = Drug::find($id);
        $drug->delete();
        return response()->json();            
        
    }
}
