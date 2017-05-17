<?php

namespace Tests\Unit;

use App\Models\Patient;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//Link to another patient resource that concerns the same actual patient.

class PatientLinkTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function setVariables()
    {
    	$patientId  = factory(Patient::class)->create()->id;
        $other  = factory(Patient::class)->create()->id;
        $this->PatientLinkData = array (
        	'patient_id' => $patientId,
            'other' => $other,
            'type' => factory(\App\CodeableConcepts::class)->create()->id
    		);
    	$this->PatientLinkDataUpdate = array (
            'other' => $other,
            'type' => factory(\App\CodeableConcepts::class)->create()->id
    		);
    }
     public function testStorePatientLink()
    {
        
        $PatientLinks =$this->PatientLinkData;

        $this->post('/api/patientlink/', $PatientLinks);

        $this->assertDatabaseHas('patient_links',$PatientLinkArray);
    }
    public function testUpdatePatientLink()
    {


    $patientlink = factory(Patient::class,3)->make();
    $this->post('api/patient_links',$patientlink);

    $SavedPatientLink = Patient::orderBy('id','desc')->take(1)->get()->toArray();

    $PatientLinkUpdated = $this->update(
    $this->PatientLinkDataUpdate,$SavedPatientLink[0]['id']);
    $updated = $this->put('api/patient_links',$PatientLinkUpdate);

     $this->assertEquals(200,$updated);

    }

    public function testDeletePatientLink()
    {
        factory(Patient::class,3)->make();
    	$patientlink = Patient::orderBy('id','desc')
    	              ->take(1)->get()->toArray();
    	$PatientLinkDeleted = $patientlink
    	->delete('api/patient_links',$patientlink[0]['id']);
        
       $this->assertEquals(200, $PatientLinkDeleted->getStatusCode());

    }

    public function testShowPatientLink()
    {
      $PatientLinks = factory(Patient::class,3)->create();
     $PatientLink = $this->json('GET','api/patient_links',$PatientLinks)
     					->seeJson([
     						'result'=>true]);

     $array = json_decode($PatientLink);
     $result = false;

     if($array[0]->id ==1)
     {
     	$result = true;
     }

     $this->assertEquals(true,$result);
     
    }
}
