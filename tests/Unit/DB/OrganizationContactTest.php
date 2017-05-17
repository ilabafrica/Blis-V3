<?php

namespace Tests\Feature;

use Organization;
use App\User;
use App\UserType;
use Faker\Generator as Facker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrganizationContactTest extends TestCase
{
	// Organization on behalf of which the contact is acting or for which the contact is working.
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
     

     public function setVariables()
     {
     	$userId  = factory(User::class)->create()->id;
     	$this->OrganizationContactData = array (
           'organization_id' => factory(Organization::class)->create(['user_id'=>$userId])->id,
            'purpose' =>  factory(\App\CodeableConcepts::class)->create()->id,
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
     		);
     	$this->OrganizationContactDataUpdate = array (
           
            'purpose' => factory(\App\CodeableConcepts::class)->create()->id,
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
     		);

     }
         public function testStoreOrganizationContact()
    {
        
       $OrganizationContacts = $this->OrganizationContactData;

        $this->post('/api/organizationcontact/', $OrganizationContacts);

        $this->assertDatabaseHas('organization_contact',$OrganizationContactArray);
    }
    public function testUpdateOrganizationContact()
    {
       $organizationcontact = factory(OrganizationContact::class,3)->make();
    $this->post('api/organizationcontact',$organizationcontact);

    $organizationcontactSaved = Organization::orderBy('id','desc')->take(1)->get()->toArray();

    $OrganizationcontactUpdated = $this->update(
    $this->OrganizationContactDataUpdate,$organizationcontactSaved[0]['id']);
    $this->put('api/organizationcontact',$OrganizationcontactUpdated);

     $this->assertEquals($OrganizationcontactUpdated->name,$OrganizationContactDataUpdate['name']);
    }

    public function testDeleteOrganizationContact()
    {
    	factory(Organization::class,3)->make();
    	$organizationcontact = Organization::orderBy('id','desc')
    	              ->take(1)->get()->toArray();
    	$OrganizationContactDeleted = $organization
    	->delete('api/organizationcontact',$organizationcontact[0]['id']);
        
       $this->assertEquals(200, $OrganizationContactDeleted->getStatusCode());
    }

    public function testShowOrganizationContact()
    {
    $organizationcontacts = factory(Organization::class,3)->create();
     $organaizationcontact = $this->json('GET','api/organizationcontact',$organizationcontacts)
     					->seeJson([
     						'result'=>true]);

     $array = json_decode($organaizationcontact);
     $result = false;

     if($array[0]->id ==1)
     {
     	$result = true;
     }

     $this->assertEquals(true,$result);
     
    }
    
}
