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
            'practitioner_id' => 1,
            'organization_id' => factory(Organization::class)->create()->id
        ];
        factory(\App\Models\Patient::class)->create($patientArray);
        $response=$this->json('POST', '/api/patient', $patientArray);
        
        $response->assertStatus(200)->assertHasKey("birth_date");

        $this->assertDatabaseHas('patients',$patientArray);
    }

    public function testDeletePatient()
    {
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
            'practitioner_id' => 1,
            'organization_id' => factory(Organization::class)->create()->id
        ];
        
        factory(\App\Models\Patient::class)->create($patientArray);
        factory(\App\Models\Patient::class)->create();
		$response=$this->delete('api/patient/1');
		$response->assertStatus(200);
    }

    public  function testUpdate()
   {
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
            'practitioner_id' => 1,
            'organization_id' => factory(Organization::class)->create()->id
        ];
        factory(\App\Models\Patient::class)->create($patientArray);

        $updatePatientArray = [
            'deceased' => \Faker\Factory::create()->boolean(),
            'address' => factory(Address::class)->create()->id,
            'marital_status' => factory(CodeableConcept::class)->create()->id,
            'multiple_birth' => 1,
            'photo' => 'path/to/photo/here',
            'general_practitioner_type' => \Faker\Factory::create()->randomElement(['organization', 'practitioner']),
            'practitioner_id' => 1,
            'organization_id' => factory(Organization::class)->create()->id
        ];

        $response=$this->json('PUT', '/api/patient/1', $patientArray);
        
        $response->assertStatus(200)->assertHasKey("address");

        $this->assertDatabaseHas('patients',$patientArray);

   }

   public function testShowPatient()
   {
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
            'practitioner_id' => 1,
            'organization_id' => factory(Organization::class)->create()->id
        ];
        factory(\App\Models\Patient::class)->create($patientArray);
        $response=$this->json('GET', '/api/patient/1', $patientArray);
        $response->assertStatus(200)->assertHasKey("address");
        $this->assertDatabaseHas('patients',$patientArray);
   }

}
