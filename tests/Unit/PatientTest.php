<?php

namespace Tests\Unit;

use App\Models\HumanName;
use App\Models\CodeableConcept;
use App\Models\Organization;
use App\User;
use App\UserType;
use App\Models\Patient;
use App\Models\Address;
use Faker\Generator as Facker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//Demographics and other administrative information about an individual or animal receiving care or other health-related services.

class PatientTest extends TestCase
{
    use DatabaseMigrations;

    public function setup()
    {
        parent::Setup();
        $this->setVariables();
    }

    public function setvariables()
    {
        $userTypeId  = factory(UserType::class)->create(['name'=>'patient'])->id;
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;
        $this->input= array(
            'user_id' => $userId,
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'gender' => factory(CodeableConcept::class)->create()->id,
            'birth_date' => \Faker\Factory::create()->date(),
            'deceased' => \Faker\Factory::create()->boolean(),
            'address' => factory(Address::class)->create()->id,
            'marital_status' => factory(CodeableConcept::class)->create()->id,
            'multiple_birth' => 1,
            'photo' => 'path/to/photo/here',
            'general_practitioner_type' => \Faker\Factory::create()->randomElement(['organization', 'practitioner']), 
            'general_practitioner_id' => 1,
            'managing_organization' => factory(Organization::class)->create()->id
        );

      $this->PatientUpdate = array(
             'gender' => factory(CodeableConcept::class)->create()->id,
            'birth_date' => \Faker\Factory::create()->date(),
            'deceased' => \Faker\Factory::create()->boolean(),
            'address' => factory(Address::class)->create()->id,
            'marital_status' =>factory(CodeableConcept::class)->create()->id,
            'multiple_birth' => 1,
            'general_practitioner_type' => \Faker\Factory::create()->randomElement(['organization', 'practitioner']),
            'general_practitioner_id' => 1,
            'managing_organization' => factory(Organization::class)->create()->id);
    }
    public function testStorePatient()
    {
        $userTypeId  = factory(UserType::class)->create(['name'=>'patient'])->id;
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;
        $patientArray = [
            'user_id' => $userId,
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'gender' => factory(CodeableConcept::class)->create()->id,
            'birth_date' => \Faker\Factory::create()->date(),
            'deceased' => \Faker\Factory::create()->boolean(),
            'address' => factory(Address::class)->create()->id,
            'marital_status' => factory(CodeableConcept::class)->create()->id,
            'multiple_birth' => 1,
            'photo' => 'path/to/photo/here',
            'general_practitioner_type' => \Faker\Factory::create()->randomElement(['organization', 'practitioner']),
            'general_practitioner_id' => 1,
            'managing_organization' => factory(Organization::class)->create()->id
        ];

        $this->post('/api/patient/', $patientArray);

        $this->assertDatabaseHas('patients',$patientArray);
    }

    public function testDeletePatient()
    {
        //TODO
    }

    public  function testUpdate()
   {
        //TODO
   }

   public function testShowPatient()
   {
        //TODO
   }

}
