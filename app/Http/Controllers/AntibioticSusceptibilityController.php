<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 */

use Illuminate\Http\Request;
use App\Models\AntibioticSusceptibility;

class AntibioticSusceptibilityController extends Controller
{
    public function index(Request $request)
    {
        $antibioticSusceptibility = AntibioticSusceptibility::with(
            'susceptibilityRange',
            'result.measureRange',
            'antibiotic')->where('result_id', $request->result_id)->get();

        return response()->json($antibioticSusceptibility);
    }
}
