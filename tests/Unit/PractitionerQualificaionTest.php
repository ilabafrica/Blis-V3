<?php
namespace Tests\Unit;

use App\Models\Practitioner;
use App\User;
use App\Models\Organization;
use Faker\Generator as Facker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
 
 // Qualifications obtained by training and certification.

class PractitionerQualificaionTest extends TestCase
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
        $this->assertDatabaseHas('practitioner_qualifications',$this->PractitionerQualificationData);
    }

    public function testUpdatePractitionerQualification()
    {
        //TODO
    }

    public function testDeletePractitionerQualification()
    {
    	//TODO
    }

    public function testShowPractitionerQualification()
    {
    	//TODO
    }
}
