<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('name', 'ASC')->get();
        return response()->json($suppliers);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'name' => 'required|unique:suppliers,name');
        $validator = Validator::make(Input::all(), $rules);

        
        if ($validator->fails()) {
            return response()->json();
            
        } else {
            // store
            $supplier = new Supplier;
            $supplier->name= Input::get('name');
            $supplier->phone= Input::get('phone');
            $supplier->email= Input::get('email');
            $supplier->address= Input::get('address');
            $supplier->user_id = Auth::user()->id;           
            $supplier->save();
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
        $supplier =Supplier::find($id);
        return response()->json($supplier);
        
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

        // process the request
        if ($validator->fails()) {
            return response()->json();
            
        } else {
        // Update
            $supplier = Supplier::find($id);
            $supplier->name= Input::get('name');
            $supplier->address= Input::get('address');
            $supplier->phone= Input::get('phone');
            $supplier->email= Input::get('email');
            $supplier->user_id = Auth::user()->id;
            $supplier->save();

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
        $supplier = Supplier::find($id);
        $supplier->delete();
        return response()->json();
        
    }
}
