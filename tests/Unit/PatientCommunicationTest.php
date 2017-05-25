<?php

namespace Tests\Unit;

use App\User;
use App\UserType;
use App\Models\Patient;
use App\Models\CodeableConcept;
use Faker\Generator as Facker; 
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

 // Languages which may be used to communicate with the patient about his or her health.

class PatientCommunicationTest extends TestCase
{
	use DatabaseMigrations;

    public function setup()
    {
        parent::Setup();
        $this->setVariables();
    }

    public function setVariables()
    {
    	 $userId  = factory(User::class)->create()->id;
    	 $patientId  = factory(Patient::class)->create(['user_id'=>$userId])->id;
         $this->PatientCommunicationData = array (
            'patient_id' => $patientId,
            'language' => factory(CodeableConcept::class)->create()->id
         	);
         $this->patientcommunicationdataupdate = array(
            factory(CodeableConcept::class)->create()->id
         	);

    }
    public function testStorePatientCommunication()
    {
        $this->post('/api/patientcommunication/',$this->PatientCommunicationData);

        $this->assertDatabaseHas('patient_communications', $this->PatientCommunicationData);
    }
    public function testUpdatePatientCommunication()
    {
        //TODO
    }
     

    public function testDeletePatientCommunication()
    {
    	//TODO
    	
    }
    public function testShowPatientCommunication()
    {
        //TODO
    }
}
