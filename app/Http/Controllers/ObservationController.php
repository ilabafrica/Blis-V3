<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$observations = Observation::orderBy('id', 'desc')->paginate();
		return response()->json($observations);
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
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Observation  $observation
	 * @return \Illuminate\Http\Response
	 */
	public function show(Observation $observation)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Observation  $observation
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Observation $observation)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Observation  $observation
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Observation $observation)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Observation  $observation
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Observation $observation)
	{
		//
	}
}
