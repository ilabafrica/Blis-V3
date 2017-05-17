<?php

namespace Tests\Feature;

use App\DB\HumanName;
use App\DB\User;
use App\DB\UserType;
use App\DB\Practitioner;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

 //A person who is directly or indirectly involved in the provisioning of healthcare.

class PractitionerTest extends TestCase
{
	use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */


    public function setVariables()
    {   

    	$userTypeId  = factory(UserType::class)->create(['name'=>'practitioner'])->id;
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;
    	$this->PractitionerData = array
    	( 
    		'user_id' => $userId,
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
            'gender' =>  \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
            'birth_date' => \Faker\Factory::create()->date(),
            'photo' =>  \Faker\Factory::create()->url
            );
    	$this->PractitionerDataUpdate = array 
    	 (
          
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
            'gender' =>  \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
            'birth_date' => \Faker\Factory::create()->date(),
            
    		);
    }
    public function testStore()
    {
        
        $PractitionerArray = $this->PractitionerData;
          

        $this->post('/api/practitioner/', $PractitionerArray);

        $this->assertDatabaseHas('practitioners',$PractitionerArray);
    }

    public function testUpdatePractitioner()
    {
    	
      $practitioner = factory(Practitioner::class,3)->make();
      $this->post('api/practitioner',$practitioner);
    
    $practitionerSaved  = Practitioner::orderBy ('id','desc')->take(1)->get()->toArray();
    $practitionerUpdated = $this->update(
    		$this->PractitionerDataUpdate,$practitionerSaved[0]['id']);

    $this->put('api/HumanName',$practitionerUpdated);
    $this->assertEquals($practitionerUpdated->name,
    	$this->practitionerUpdated['name']);
    }

    public function testDeletePractitioner()
    {
    	factory(Practitioner::class,3)->make();
    	$Practitioner = Practitioner::orderBy('id','desc')->take(1)->get()->toArray();
    	$PractitionerDeleted = $Practitioner->delete('api/Practitioner',$practitioner[0]['id']);
    }

    public function testShowPractitioner()
       {
    	$Practitioners = factory(Practitioner::class,3)->create();
    	$Practitioner = $this->json('GET','api/practitioner',$Practitioners)
    					 ->seeJson([
    					 	'result'=>true]);
    	$array = json_decode($Practitioner);
    	$result = false;

    	if($array[0]->id==1)
    	{
    		$result = true;
    	}
    	$this->assertEquals(true, $result);
    }
}
