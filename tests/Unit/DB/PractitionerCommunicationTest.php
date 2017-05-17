<?php

namespace Tests\Feature;

use App\DB\HumanName;
use App\DB\User;
use App\DB\UserType;
use App\DB\Practitioner;
use Faker\Generator as Facker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//A language the practitioner is able to use in patient communication.

class PractitionerCommunicationTest extends TestCase
{
	use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function setVariables()
    {
        $practitionerId  = factory(Practitioner::class)->create()->id;
        $PractitionerId  = factory(Practitioner::class)->create()->id;
        $this->PractitionerCommunicationData = array (
            'practitioner_id' => $practitionerId,
            'Practitioner_id' => $PractitionerId,
            'language' =>  factory(\App\CodeableConcepts::class)->create()->id
            );
        $this->PractitionerCommunicationDataUpdate = array (
              'language' =>  factory(\App\CodeableConcepts::class)->create()->id
            );
        
    }
    public function testStorePractitionerCommunication()
    {
        
       $practitionercommunication = $this->PractitionerCommunicationData;
        $this->post('/api/practitionercommunication/', $practitionercommunication);

        $this->assertDatabaseHas('practitioner_communication',$practitionercommunication);
    }
    public function testUpdatePractitionerCommunication()
    {

        $PractitionercommunicationSaved = Practitioner::orderBy('id','dec')->take(1)->get()->toArray();

     $UpdatePractitionerCommunication =  $this->update($this->PractitionerCommunicationDataUpdate,$PractitionercommunicationSaved[0]['id']);

    $this->put('api/practitioner_communications',$UpdatePractitionerCommunication);
    }
     

    public function testDeletePractitionerCommunication()
    {
        $Practitionercommunications = factory(App\Practitioner::class,3)->make();

        $PractitionerCommunication = Practitioner::orderBy('id','dec')->take(1)->get()->toArray();

        $PractitionerCommunicationDeleted = $Practitioner->delete('api/practitioner_communications',$Practitioner[0]['id']);
        
        $this->assertEquals(200, $PractitionerCommunicationDeleted->getStatusCode());
        
    }
    public function testShowPractitionerCommunication()
    {
     $PractitionerCommunication = factory(Practitioner::class,3)->create();

    $Practitionercommunications =  $this->json('GET','api/practitioner_communications',$PractitionerCommunication)
                    ->seejson([
                        'created'=> true,
                        ]);
    
    $array = json_decode($Practitionercommunicationss);
   
     $result = false;

     if ($array[0]->id==1)
     {
        $result = true;
     }
     $this->assertEquals(true, $result);   
    
    }
}
