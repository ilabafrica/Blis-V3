<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  Get item
        $items = Item::orderBy('name', 'ASC')->get();
        //  Barcode
        $barcode = Barcode::first();
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
        //Validation
        $rules = array(
            'item_id'   => 'required:inv_supply,item_id',
            'supplier_id'   => 'required:inv_supply,supplier_id'
        );
        $validator = Validator::make(Input::all(), $rules);
    
        //process
        if($validator->fails()){
            return response()->json();
        }else{
            //store
            $stock = new Stock;
            $stock->item_id = Input::get('item_id');
            $stock->lot = Input::get('lot');
            $stock->batch_no = Input::get('batch_no');
            $stock->expiry_date = Input::get('expiry_date');
            $stock->manufacturer = Input::get('manufacturer');
            $stock->supplier_id = Input::get('supplier_id');
            $stock->quantity_supplied = Input::get('quantity_supplied');
            $stock->cost_per_unit = Input::get('cost_per_unit');
            $stock->date_of_reception = Input::get('date_of_reception');
            $stock->remarks = Input::get('remarks');
            $stock->user_id = Auth::user()->id;

            $stock->save();
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
        $stock = Stock::find($id);
        return response()->json($stock);
        
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
        $rules = array(
            'item_id'   => 'required:inv_supply,item_id',
            'supplier_id'   => 'required:inv_supply,supplier_id'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return response()->json($stock);
        } else {
            //store
            $stock = Stock::find($id);
            $stock->item_id = Input::get('item_id');
            $stock->lot = Input::get('lot');
            $stock->batch_no = Input::get('batch_no');
            $stock->expiry_date = Input::get('expiry_date');
            $stock->manufacturer = Input::get('manufacturer');
            $stock->supplier_id = Input::get('supplier_id');
            $stock->quantity_supplied = Input::get('quantity_supplied');
            $stock->cost_per_unit = Input::get('cost_per_unit');
            $stock->date_of_reception = Input::get('date_of_reception');
            $stock->remarks = Input::get('remarks');

            $stock->user_id = Auth::user()->id;
            $stock->save();

            // redirect
            return response()->json($stock);
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
        $stock = Stock::find($id);
        $stock->delete();
        
        return response()->json($stock);

    }

    public function usage($id, $req = null)
    {
        //  Get stock
        $stock = Stock::find($id);
        //  Get Requests
        $requests = $stock->item->requests;
        if($req)
            $record = $req;
        else
            $record = 0;
        //show the view and pass the $stock to it
        return response()->json($stock);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function saveStockUsage()
    {
        //Validate
        $rules = array(
            'stock_id'   => 'required:inv_usage,stock_id',
            'request_id'   => 'required:inv_usage,request_id',
            'issued_by'   => 'required:inv_usage,issued_by',
            'received_by'   => 'required:inv_usage,received_by'
        );
        $validator = Validator::make(Input::all(), $rules);
        //process
        if($validator->fails())
        {
            return response()->json($stock);
        }
        else
        {
            $usage = new Usage;
            $usage->stock_id = Input::get('stock_id');
            $usage->request_id = Input::get('request_id');
            $usage->quantity_used = Input::get('quantity_used');
            $usage->date_of_usage = Input::get('date_of_usage');
            $usage->issued_by = Input::get('issued_by');
            $usage->received_by = Input::get('received_by');
            $usage->remarks = Input::get('remarks');
            $usage->user_id = Auth::user()->id;
            $usage->save();
            
            return response()->json();
            // for validation in the Top up and Stock mdels to display different messages in the views.
            
            $url = Session::get('SOURCE_URL');
            if($usage->quantity_used>Stock::find((int)$usage->stock_id)->quantity())
            {
                return Redirect::back()->with('message', trans('messages.insufficient-stock'))->withInput(Input::all());
            }
            else if($usage->quantity_used>Topup::find((int)$usage->request_id)->quantity_ordered)
            {
                return Redirect::back()->with('message', trans('messages.issued-greater-than-ordered'))->withInput(Input::all());
            }
            else
            {
                $usage->save();        
                return Redirect::to($url)->with('message', trans('messages.record-successfully-updated'))->with('active_stock', $usage->stock->id);
            }
        }
    }
    /**
     * lot usage
     *
     * @param  int  $id
     * @return Response
     */
    public function lot($id)
    {
        //  Get lot usage
        $lt = Usage::find($id);
        //  Get Requests
        $requests = Topup::all();
        //  Get request
        $request = $lt->request_id;
        //show the view and pass the $stock to it
        return response()->json();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function lotUsage()
    {
        $id = Input::get('id');
        $rules = array(
            'stock_id'   => 'required:inv_usage,stock_id',
            'request_id'   => 'required:inv_usage,request_id',
            'issued_by'   => 'required:inv_usage,issued_by',
            'received_by'   => 'required:inv_usage,received_by'
        );
        $validator = Validator::make(Input::all(), $rules);
        //process
        if($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        return response()->json($stock);
        }
        else
        {
            $usage = Usage::findOrFail($id);
            $usage->stock_id = Input::get('stock_id');
            $usage->quantity_used = Input::get('quantity_used');
            $usage->date_of_usage = Input::get('date_of_usage');
            $usage->issued_by = Input::get('issued_by');
            $usage->received_by = Input::get('received_by');
            $usage->remarks = Input::get('remarks');
            $usage->user_id = Auth::user()->id;
            $usage->save();

            // for validation in the Top up and Stock mdels to display different messages in the views.
            $url = Session::get('SOURCE_URL');
            if($usage->quantity_used>Stock::find((int)$usage->stock_id)->quantity())
            {
                return Redirect::back()->with('message', trans('messages.insufficient-stock'))->withInput(Input::all());
            }
            else if($usage->quantity_used>Topup::find((int)$usage->request_id)->quantity_ordered)
            {
                return Redirect::back()->with('message', trans('messages.issued-greater-than-ordered'))->withInput(Input::all());
            }
            else
            {
                $usage->save();
            
                return Redirect::to($url)->with('message', trans('messages.record-successfully-updated'))->with('active_stock', $usage->stock->id);
            // }
        return response()->json($stock);
        }
    }
}
