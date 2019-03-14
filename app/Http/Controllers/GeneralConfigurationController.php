<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralConfiguration;

class GeneralConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $generalconfig = GeneralConfiguration::whereId(1)->first();

        return response()->json($generalconfig);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $generalconfig = GeneralConfiguration::whereId($id)->first();
            if (is_null($generalconfig)) {
                $generalconfig = new GeneralConfiguration;
                $generalconfig->name = $request->input('name');
                $generalconfig->email = $request->input('email');
                $generalconfig->phone = $request->input('phone');
                $generalconfig->post = $request->input('post');
                $generalconfig->address = $request->input('address');
                $generalconfig->code = $request->input('code');

                try {
                    $generalconfig->save();

                    return response()->json($generalconfig);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                $generalconfig->name = $request->input('name');
                $generalconfig->email = $request->input('email');
                $generalconfig->phone = $request->input('phone');
                $generalconfig->post = $request->input('post');
                $generalconfig->address = $request->input('address');
                $generalconfig->code = $request->input('code');

                try {
                    $generalconfig->save();

                    return response()->json($generalconfig);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            }
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
                $fileName = rand(11111, 99999).'.'.$extension;
                $request->file('file')->storeAs('profile_pictures', $fileName);
            }
            $user = GeneralConfiguration::findOrFail($request->input('id'));
            $user->logo = $fileName;
            try {
                $user->save();

                return response()->json($user);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
}
