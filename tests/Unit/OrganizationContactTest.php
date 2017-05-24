<?php

namespace Tests\Unit;

use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Models\CodeableConcept;
use App\Models\HumanName;
use App\Models\ContactPoint;
use App\Models\Address;
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
    
    public function setup()
    {
        parent::Setup();
        $this->setVariables();
    }

    public function setVariables()
    {
    	$userId  = factory(User::class)->create()->id;
    	$this->OrganizationContactData = array (
       'organization_id' => factory(Organization::class)->create(['user_id'=>$userId])->id,
        'purpose' =>  factory(CodeableConcept::class)->create()->id,
        'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
        'telecom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
        'address' => factory(Address::class)->create()->id,
    		);
    	$this->OrganizationContactDataUpdate = array (
       
        'purpose' => factory(CodeableConcept::class)->create()->id,
        'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
        'telecom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
        'address' => factory(Address::class)->create()->id,
    		);

}
    public function testStoreOrganizationContact()
    {
        $this->post('/api/organizationcontact/', $this->OrganizationContactData);

        $this->assertDatabaseHas('organization_contacts',$this->OrganizationContactData);
    }
    public function testUpdateOrganizationContact()
    {
        //TODO
    }

    public function testDeleteOrganizationContact()
    {
    	//TODO
    }

    public function testShowOrganizationContact()
    {
        //TODO
    }
    
}
