<?php

namespace Tests\Unit;


use App\Models\Organization;
use App\UserType;
use App\Models\CodeableConcept;
use App\Models\ContactPoint;
use App\Models\Address;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//A formally or informally recognized grouping of people or organizations formed for the purpose of achieving some form of collective action. Includes companies, institutions, corporations, departments, community groups, healthcare practice groups, etc.

class OrganizationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseMigrations;

    public function setup()
    {
        parent::Setup();
        $this->setVariables();
    }

    public function setVariables()
    {
    	$userTypeId  = factory(UserType::class)->create(['name'=>'organization'])->id;
        
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;#
        $this->organizationData = array
    	( 
    		'user_id' => $userId,
            'type' =>  factory(CodeableConcept::class)->create()->id,
            'name' => \Faker\Factory::create()->word,
            'alias' => \Faker\Factory::create()->word,
            'telecom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create()->id,
            'part_of' => factory(Organization::class)->create(['user_id'=>$userId])->id,
            'end_point' =>  \Faker\Factory::create()->url
        
        );
        $this->organizationDataUpdate = array (
            
            'type' => factory(CodeableConcept::class)->create()->id,
            'name' => \Faker\Factory::create()->word,
            'alias' => \Faker\Factory::create()->word,
            'telecom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create()->id,
            'part_of' => factory(Organization::class)->create(['user_id'=>$userId])->id,
            'end_point' =>  \Faker\Factory::create()->url
        
        	);
    }
    public function testStore()
    {
         $this->post('/api/organization', $this->organizationData);

        $this->assertDatabaseHas('organizations',$this->organizationData);
    }

    public function testUpdate()
    {
        //TODO
    }

    public function testOrganizationDelete()
    {
        //TODO
    }

    public function testShowOrganizations()
    {
        //TODO
    }
}
