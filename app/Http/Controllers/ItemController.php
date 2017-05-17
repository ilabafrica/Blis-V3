<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items =Item::orderBy('name', 'ASC')->get();
        return response()->json($items);
        
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
        $rules = array('name' => 'required|unique:inv_items,name');
        $validator = Validator::make(Input::all(), $rules);
    
        //process
        if($validator->fails()){
            return response()->json();
        }else{
            //store
            $item = new Item;
            $item->name = Input::get('name');
            $item->unit = Input::get('unit');
            $item->remarks = Input::get('remarks');
            $item->min_level = Input::get('min_level');
            $item->max_level = Input::get('max_level');
            $item->storage_req = Input::get('storage_req');

            $item->user_id = Auth::user()->id;
            $item->save();
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
        $item =Item::find($id);
        //  Barcode
        $barcode = Barcode::first();
        return response()->json($item);
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
        $validator = Validator::make(Input::all(), $rules);

        // process
        if ($validator->fails()) {
            return response()->json($item);
        } else {
            //store
            $item = Item::find($id);
            $item->name = Input::get('name');
            $item->unit = Input::get('unit');
            $item->remarks = Input::get('remarks');
            $item->min_level = Input::get('min_level');
            $item->max_level = Input::get('max_level');
            $item->storage_req = Input::get('storage_req');

            $item->user_id = Auth::user()->id;
            $item->save();

            // redirect
            return response()->json($item);
           
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
        //
    }
}
