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
 

   $count = Specimen::count() + 1;
        $tracker =date('Y_m_d');

$data = 'ILAB_'.$count. '_'.$tracker;

  /*  print json_encode($data, JSON_NUMERIC_CHECK);*/

}

  public function store(Request $request){

   $data = new SpecimenTrackerModel;
$data->save();
        

    }
  



    

}
