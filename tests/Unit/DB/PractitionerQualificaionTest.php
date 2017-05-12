<?php

namespace Tests\Feature;

use App\DB\Practitioner;
use Faker\Generator as Facker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PractitionerQualificaionTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    /**Test*/


    public function setVariables()
    {
    	$userId  = factory(User::class)->create()->id;
        $practitionerId  = factory(Practitioner::class)->create(['user_id'=>$userId])->id;
    	$this->PractitionerQualificationData = array(
            
            'practitioner_id' => $practitionerId,
            'name' => \Faker\Factory::create()->word,
            'period' => \Faker\Factory::create()->date(),
            'issuer' => factory(Organization::class)->create(['user_id'=>$userId])->id

       
    		);
    	$this->PractitionerQualificationDataUpdate = array 
    	(
    		'name' => \Faker\Factory::create()->word,
            'period' => \Faker\Factory::create()->date(),
            'issuer' => factory(Organization::class)->create(['user_id'=>$userId])->id
    		);
    }
    public function testStorePractitionerQualification()
    {
        
           

        $this->post('/api/practitionerqualification/', $this->PractitionerQualificationData);

        $this->assertDatabaseHas('practitioner_qualifications',$PractitionerQualificationData);
    }
    public function testUpdatePractitionerQualification()
    {
        $PracQualification = factory(Practitioner::class,3)->make();
        $this->post('api/practitionerqualification',$PracQualification);
        $PracQualificationSaved = Practitioner::orerBy('id','desc')->take(1)->get()->toArray();
        $PracQualificationUpdated = $this->update(
        	$this->PractitionerQualificationDataUpdate,$PracQualificationSaved[0]['id']);
        $this->put('api/practitionerqualification',$PracQualificationUpdated);
        $this->assertEquals($PracQualificationUpdated->name,$PractitionerQualificationDataUpdate['name']);
    }

    public function testDeletePractitionerQualification()
    {
    	factory(Practitioner::class,3)->make();
    	$PracQualification = Practitioner::orderBy('id','desc')->take(1)->get()->toArray();
    	$PracQualificationDeleted = $PracQualification->delete('api/practitionerqualification',$PracQualificationDeleted[0]['id']);


    $this->assertEquals(200,$PracQualificationDeleted->getStatusCode());
    }

    public function testShowPractitionerQualification()
    {
    	$PracQualifications = factory(Practitioner::class,3)->make();
    	$PracQualification = json('GET','api/practitionerqualification',$PracQualifications)
    				->seeJson([
    					'result'=> true]);
    	$array = json_decode($PracQualification);
    	$result = false;

    	if($array[0]->id==1)
    	{
            $result = true;
    	}
    	$this->assertEquals(true, $result);
    }
}
