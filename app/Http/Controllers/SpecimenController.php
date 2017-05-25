<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specimen;

class SpecimenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $specimentypes = Specimen::orderBy('id', 'ASC')->get();
        
        //load a raw set of specimens

        // if(Input::has('raw')){
        // }
        return response()->json($specimentypes);
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
        $rules = array('type' => 'required|unique:specimen_types,type');
        $validator = Validator::make(Input::all(), $rules);

        // process the inputs
        if ($validator->fails()) {
            return response()->json();
        } else {
            // store
            $specimentype = new Specimen;
            $specimentype->type = Input::get('type');
            $specimentype->status = Input::get('status');
            $specimentype->save();

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
        $specimentype = Specimen::find($id);
        
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
        $rules = array('name' => 'required');
        $validator = Validator::make(Input::all(), $rules);
      
        if ($validator->fails()) {
            return response()->json($validator);  
        } else {
            // Update
            $specimentype = Specimen::find($id);
            $specimentype->type = Input::get('type');
            $specimentype->status = Input::get('status');
            $specimentype->save();

            // redirect
            return response()->json($validator);
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
        $specimentype = Specimen::find($id);
        $specimentype->delete();
        
    }

    
}
