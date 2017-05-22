<?php

namespace Tests\Unit;

use App\User;
use App\UserType;
use App\Models\Patient;
use Faker\Generator as Facker; 
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

 // Languages which may be used to communicate with the patient about his or her health.

class PatientCommunicationTest extends TestCase
{
	use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function setVariables($value='')
    {
    	 $userId  = factory(User::class)->create()->id;
    	 $patientId  = factory(Patient::class)->create(['user_id'=>$userId])->id;
         $this->PatientCommunicationData = array (
            'patient_id' => $patientId,
            'language' => factory(\App\CodeableConcepts::class)->create()->id
         	);
         $this->patientcommunicationdataupdate = array(
            factory(\App\CodeableConcepts::class)->create()->id
         	);

    }
     public function testStorePatientCommunication()
    {
       
        
        $PatientCommunication = $this->PatientCommunicationData;
            

        $this->post('/api/patientcommunication/', $PatientCommunication);

        $this->assertDatabaseHas('patient_communications',$PatientCommunicationArray);
    }
    public function testUpdatePatientCommunication()
    {

        $patientcommunicationSaved = Patient::orderBy('id','dec')->take(1)->get()->toArray();

     $UpdatePatientCommunication =  $this->update($this->patientcommunicationdataupdate,$patientcommunicationSaved[0]['id']);

    $this->put('api/patient_communications',$updatePatientCommunication);
    }
     

    public function testDeletePatientCommunication()
    {
    	$patientcommunications = factory(App\patient::class,3)->make();

        $PatientCommunication = Patient::orderBy('id','dec')->take(1)->get()->toArray();

        $PatientCommunicationDeleted = $PatientCommunication->delete('api/patient_communications',$patient[0]['id']);
        
        $this->assertEquals(200, $PatientCommunicationDeleted->getStatusCode());
    	
    }
    public function testShowPatientCommunication()
    {
     $PatientCommunication = factory(Patient::class,3)->create();

    $patientcommunications =  $this->json('GET','api/patient_communications',$PatientCommunication)
                    ->seejson([
                        'created'=> true,
                        ]);
    
    $array = json_decode($patientcommunicationss);
   
     $result = false;

     if ($array[0]->id==1)
     {
        $result = true;
     }
     $this->assertEquals(true, $result);   
   	
    }
}
