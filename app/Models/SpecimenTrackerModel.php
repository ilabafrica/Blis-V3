<?php


namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class SpecimenTrackerModel extends Model
{
    //

//public $incrementing = false;

  protected $table = 'specimenids';
protected $fillable= [
    	
    	'specimens_id',
    	

 ];

     public function specimen(){
        return $this->belongsTo('App\Models\Specimen');
    }



}




    /**
     * Boot function from laravel.
     */
  
