<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DB;

/*
    Demographics and other administrative information about an individual or animal receiving care or
    other health-related services.racking patient is the center of the healthcare process.
    https://www.hl7.org/fhir/patient.html
*/

class Patient extends Model
{
    protected $table = 'patients';

    protected $fillable = ['identifier'];

    public function address()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function maritalStatus()
    {
        return $this->hasOne('App\Models\CodeableConcept', 'code');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function name()
    {
        return $this->hasOne('App\Models\Name', 'id', 'name_id');
    }

    public function gender()
    {
        return $this->hasOne('App\Models\Gender', 'id', 'gender_id');
    }

    public function practitioner()
    {
        return $this->hasOne('App\Models\Practitioner');
    }

    public function tests()
    {
        return $this->hasManyThrough('App\Models\Test', 'App\Models\Encounter');
    }

    public function encounters()
    {
        return $this->hasMany('App\Models\Encounter');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    public function getAge($format = "YYMM", $at = NULL)
    {
        if(!$at)$at = new DateTime('now');

        $dateOfBirth = new DateTime($this->dob);
        $interval = $dateOfBirth->diff($at);

        $age = "";

        switch ($format) {
            case 'ref_range_Y':
                $seconds = ($interval->days * 24 * 3600) + ($interval->h * 3600) + ($interval->i * 60) + ($interval->s);
                $age = $seconds/(365*24*60*60);
                break;
            case 'Y':
                $age = $interval->y;break;
            case 'YY':
                $age = $interval->y ." years ";break;
            default:
                if($interval->y == 0){
                    $age = $interval->format('%a days');
                }
                elseif($interval->y > 0 && $interval->y <= 2){
                    $age = $interval->format('%m') + 12 * $interval->format('%y')." months";
                }
                else{
                    $age=$interval->y." years ";
                }
                
                break;
        }

        return $age;
    }

    public function loader()
    {
        return Patient::find($this->id)->load(
            'name',
            'gender',
            'encounter'
        );
    }

    public function getFacilityCode()
    {
        $facilityCode = AdhocConfig::where('name','Facility_Code')->first()->option;
        return $facilityCode;
    
    }

    public function getUlin(){
        $name = $this->name->given.' '.$this->name->family;
// \Log::info($this->created_at);
// \Log::info($this->name->given);
// \Log::info($this->name->family);
\Log::info($format = AdhocConfig::where('name','ULIN')->first());

        $format = AdhocConfig::where('name','ULIN')->first()->getULINFormat();
        $facilityCode ='';
        $facilityCode = $this->getFacilityCode();
        $registrationDate = date('Y-m-d H:i:s');
// \Log::info(Patient::orderBy('id','DESC')->first());
        if ($format == 'Jinja_SLMPTA') {
\Log::info('Jinja_SLMPTA');
            $lastPatientRegistration = Patient::orderBy('id','DESC')->first()->created_at;
            $monthOfLastEntry = date('m',strtotime($lastPatientRegistration));
            $monthNow = date('m');

            if ($monthOfLastEntry != $monthNow) {
                Artisan::call('reset:ulin');
            }

            $year = date('y', strtotime($registrationDate));
            $month = date('m', strtotime($registrationDate));
            $autoNum = DB::table('id_counter')->max('id')+1;
\Log::info($autoNum.'/'.$month.'/'.$year);
            return $autoNum.'/'.$month.'/'.$year;

        }elseif ($format == 'Mityana_SOP') {
\Log::info('Mityana_SOP');
            $lastPatientRegistration = Patient::orderBy('id','DESC')->first()->created_at;
            $monthOfLastEntry = date('m',strtotime($lastPatientRegistration));
            $monthNow = date('m');

            if ($monthOfLastEntry != $monthNow) {
                Artisan::call('reset:ulin');
            }

            $year = date('y', strtotime($registrationDate));
            $month = date('m', strtotime($registrationDate));
            $autoNum = DB::table('id_counter')->max('id')+1;

            $nameArray = preg_split("/\s+/", trim($name));
            $initials = null;

            foreach ($nameArray as $n){
                $initials .= $n[0];

            }
\Log::info($initials.'/'.$month.'/'.$autoNum.'/'.$year);
            return $initials.'/'.$month.'/'.$autoNum.'/'.$year;
            // MG/12/220/17
        }elseif ($format == 'Kayunga_ISO') {
\Log::info('Mityana_SOP');
            $lastPatientRegistration = Patient::orderBy('id','DESC')->first()->created_at;
            $monthOfLastEntry = date('m',strtotime($lastPatientRegistration));
            $monthNow = date('m');

            if ($monthOfLastEntry != $monthNow) {
                Artisan::call('reset:ulin');
            }

\Log::info($registrationDate);
            $year = date('y', strtotime($registrationDate));
            $month = date('m', strtotime($registrationDate));
            $autoNum = DB::table('id_counter')->max('id')+1;

            $nameArray = preg_split("/\s+/", trim($name));
            $initials = null;

            foreach ($nameArray as $n){
                $initials .= $n[0];

            }
\Log::info($initials.'/'.$month.'/'.$autoNum.'/'.$year);
            return $initials.'/'.$month.'/'.$autoNum.'/'.$year;
            // MG/12/220/17
        }elseif ($format == 'Standard') {
\Log::info('Standard');
// \Log::info($registrationDate);
// \Log::info($registrationDate);
            // $yearMonth = date('ym', strtotime($registrationDate));
            $month = date('m', strtotime($registrationDate));
            // $autoNum = DB::table('id_counter')->max('id')+1;
            $autoNum = 1;
            (new \App\Models\IdCounter)->save();
            $autoNum = \App\Models\IdCounter::orderBy('id','DESC')->first()->id;
            // IdCounter
// \Log::info($autoNum);
            $nameArray = preg_split("/\s+/", trim($name));
            $initials = null;

            foreach ($nameArray as $n){
                $initials .= $n[0];
            }
// \Log::info($facilityCode);
// \Log::info($month);
// \Log::info($autoNum);
// \Log::info($initials);
// \Log::info($facilityCode.'/'.$month.'/'.$autoNum.'/'.$initials);
\Log::info($facilityCode.'/'.$month.'/'.$autoNum.'/'.$initials);
            return $facilityCode.'/'.$month.'/'.$autoNum.'/'.$initials;
        }
    }

}
