<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use Illuminate\Http\Request;

class PanelController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$panels = Panel::orderBy('id', 'desc')->paginate();
		return response()->json($panels);
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
	 * @param  \App\Models\Panel  $panel
	 * @return \Illuminate\Http\Response
	 */
	public function show(Panel $panel)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Panel  $panel
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Panel $panel)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Panel  $panel
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Panel $panel)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Panel  $panel
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Panel $panel)
	{
		//
	}
}
