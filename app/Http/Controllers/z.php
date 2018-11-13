<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecimenTrackerModel;
use Auth;
use App\Models\Specimen;
use DB;


class SpecimenTrackerController extends Controller
{
    //
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


 public function tracker(){

        $data= DB::table('specimens') -> select(DB::raw("CONCAT('ILAB_',specimens.time_collected,'_',specimens.id) as SpecimenTracker"))->get();


            print json_encode($data, JSON_NUMERIC_CHECK);

    }


     



    

}
