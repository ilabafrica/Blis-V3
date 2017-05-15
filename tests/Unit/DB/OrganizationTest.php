<?php

namespace Tests\Feature;


use App\DB\Organization;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrganizationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseMigrations;

    public function setVariables()
    {
    	$userTypeId  = factory(UserType::class)->create(['name'=>'organization'])->id;
        
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;#
        $this->organizationData = array
    	( 
    		'user_id' => $userId,
            'type' =>  factory(\App\CodeableConcepts::class)->create()->id,
            'name' => \Faker\Factory::create()->word,
            'alias' => \Faker\Factory::create()->word,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
            'part_of' => factory(Organization::class)->create(['user_id'=>$userId])->id,
            'end_point' =>  \Faker\Factory::create()->url
        
        );
        $this->organizationDataUpdate = array (
            
            'type' => factory(\App\CodeableConcepts::class)->create()->id,
            'name' => \Faker\Factory::create()->word,
            'alias' => \Faker\Factory::create()->word,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
            'part_of' => factory(Organization::class)->create(['user_id'=>$userId])->id,
            'end_point' =>  \Faker\Factory::create()->url
        
        	);
    }
    public function testStore()
    {
         
         $this->post('/api/organization', $this->organizationData);

        $this->assertDatabaseHas('organizations',$organizationArray);
    }

    public function testUpdate()
    {


    $organization = factory(Organization::class,3)->make();
    $this->post('api/organization',$organization);

    $organizationSaved = Organization::orderBy('id','desc')->take(1)->get()->toArray();

    $OrganizationUpdated = $this->update(
    $this->organizationDataUpdate,$organizationSaved[0]['id']);
    $this->put('api/organization',$OrganizationUpdate);

     $this->assertEquals($OrganizationUpdated->name,$organizationDataUpdate['name']);

    }

    public function testOrganizationDelete()
    {
        factory(Organization::class,3)->make();
    	$organization = Organization::orderBy('id','desc')
    	              ->take(1)->get()->toArray();
    	$organizationDeleted = $organization
    	->delete('api/organization',$organization[0]['id']);
        
       $this->assertEquals(200, $organizationDeleted->getStatusCode());

    }

    public function testShowOrganizations()
    {
      $organizations = factory(Organization::class,3)->create();
     $organaization = $this->json('GET','api/organization',$organizations)
     					->seeJson([
     						'result'=>true]);

     $array = json_decode($organaization);
     $result = false;

     if($array[0]->id ==1)
     {
     	$result = true;
     }

     $this->assertEquals(true,$result);
     
    }


}
