<?php

namespace Tests\Unit;

use App\Models\Patient;
use Tests\TestCase;
use App\Models\CodeableConcept;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//Link to another patient resource that concerns the same actual patient.

class PatientLinkTest extends TestCase
{
    use DatabaseMigrations;

    public function setup()
    {
        parent::Setup();
        $this->setVariables();
    }
    
    public function setVariables()
    {
    	$patientId  = factory(Patient::class)->create()->id;
        $other  = factory(Patient::class)->create()->id;
        $this->PatientLinkData = array (
        	'patient_id' => $patientId,
            'other' => $other,
            'type' => factory(CodeableConcept::class)->create()->id
    		);
    	$this->PatientLinkDataUpdate = array (
            'other' => $other,
            'type' => factory(CodeableConcept::class)->create()->id
    		);
    }
     public function testStorePatientLink()
    {
        $this->post('/api/patientlink/', $this->PatientLinkData);

        $this->assertDatabaseHas('patient_links',$this->PatientLinkData);
    }
    public function testUpdatePatientLink()
    {
        //TODO
    }

    public function testDeletePatientLink()
    {
        //TODO
    }

    public function testShowPatientLink()
    {
        //TODO
    }
}
