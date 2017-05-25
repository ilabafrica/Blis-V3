<?php

namespace Tests\Unit;

use App\Models\HumanName;
use App\Models\CodeableConcept;
use App\User;
use App\Models\UserType;
use App\Models\Practitioner;
use Faker\Generator as Facker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//A language the practitioner is able to use in patient communication.

class PractitionerCommunicationTest extends TestCase
{
	use DatabaseMigrations;

    public function setup()
    {
        parent::Setup();
        $this->setVariables();
    }

    public function setVariables()
    {
        $practitionerId  = factory(Practitioner::class)->create()->id;
        $PractitionerId  = factory(Practitioner::class)->create()->id;
        $this->PractitionerCommunicationData = array (
            'practitioner_id' => $practitionerId,
            'Practitioner_id' => $PractitionerId,
            'language' =>  factory(CodeableConcept::class)->create()->id
            );
        $this->PractitionerCommunicationDataUpdate = array (
              'language' =>  factory(CodeableConcept::class)->create()->id
            );
        
    }
    public function testStorePractitionerCommunication()
    {
        $this->post('/api/practitionercommunication/', $this->PractitionerCommunicationData);

        $this->assertDatabaseHas('practitioner_communications',$this->PractitionerCommunicationData);
    }
    public function testUpdatePractitionerCommunication()
    {
        //TODO
    }
     

    public function testDeletePractitionerCommunication()
    {
        //TODO
    }
    public function testShowPractitionerCommunication()
    {
        //TODO
    }
}
