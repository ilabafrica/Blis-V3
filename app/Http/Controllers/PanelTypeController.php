<?php

namespace App\Http\Controllers;

use App\Models\PanelType;
use Illuminate\Http\Request;

class PanelTypeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$panelTypes = PanelType::orderBy('id', 'desc')->paginate();
		return response()->json($panelTypes);
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
	 * @param  \App\Models\PanelType  $panelType
	 * @return \Illuminate\Http\Response
	 */
	public function show(PanelType $panelType)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\PanelType  $panelType
	 * @return \Illuminate\Http\Response
	 */
	public function edit(PanelType $panelType)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\PanelType  $panelType
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, PanelType $panelType)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\PanelType  $panelType
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(PanelType $panelType)
	{
		//
	}
}
