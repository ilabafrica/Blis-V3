<?php

namespace App\Http\Controllers;


use Auth;
use App\Models\AdhocConfig;
use Illuminate\Http\Request;

class AdhocConfigController extends Controller
{
    public function index()
    {
        if (request('constants')) {
            $adhocConfigs = AdhocConfig::getConfigs();
        }else{
            $adhocConfigs = AdhocConfig::with('configOptions')->orderBy('id', 'ASC')->get();
        }
        return response()->json($adhocConfigs);
    }

    public function store()
    {
       foreach (request()->all() as $adhocConfig) {
            try {
                AdhocConfig::updateOrCreate([
                    'name'=>$adhocConfig['name']
                ],[
                    'option'=>$adhocConfig['option']
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
        return response()->json(AdhocConfig::all());
    }

    public function image(Request $request)
    {
        $rules = [
            'file' => 'image:jpeg,jpg,png|required|file',
            'id' => 'required',
            'name' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            if ($request->file('file')->isValid()) {
                $extension = $request->file('file')->getClientOriginalExtension();
                $fileName = 'logo.'.$extension;
                $request->file('file')->move('profile_pictures', $fileName);
            }
            try {
                $adhocConfig = AdhocConfig::updateOrCreate([
                    'name' => 'Logo'
                ],['option' => $fileName]);
                return response()->json($adhocConfig);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
}
