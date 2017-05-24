<?php

namespace Tests\Unit;

use App\User;
use App\UserType;
use App\Models\Practitioner;
use App\Models\Address;
use App\Models\HumanName;
use App\Models\ContactPoint;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

 //A person who is directly or indirectly involved in the provisioning of healthcare.

class PractitionerTest extends TestCase
{
	use DatabaseMigrations;

    public function setup()
    {
        parent::Setup();
        $this->setVariables();
    }

    public function setVariables()
    {   

    	$userTypeId  = factory(UserType::class)->create(['name'=>'practitioner'])->id;
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;
    	$this->PractitionerData = array
    	( 
    		'user_id' => $userId,
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create()->id,
            'gender' =>  \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
            'birth_date' => \Faker\Factory::create()->date(),
            'photo' =>  \Faker\Factory::create()->url
            );
    	$this->PractitionerDataUpdate = array 
    	 (
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create()->id,
            'gender' =>  \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
            'birth_date' => \Faker\Factory::create()->date(),
            
    		);
    }
    public function testStore()
    {
        $this->post('/api/practitioner/', $this->PractitionerData);
        $this->assertDatabaseHas('practitioners',$this->PractitionerData);
    }

    public function testUpdatePractitioner()
    {
        //TODO
    }

    public function testDeletePractitioner()
    {
    	//TODO
    }

    public function testShowPractitioner()
    {
        //TODO
    }
}
