<?php

namespace Tests\Unit;

use App\Models\HumanName;
use App\Models\CodeableConcept;
use App\Models\Organization;
use App\User;
use App\UserType;
use App\Models\Practitioner;
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
        $practitioner_id  = factory(Practitioner::class)->create()->id;
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
            'practitioner_id' => $practitioner_id,
            'organization_id' => factory(Organization::class)->create()->id
        ];
        factory(\App\Models\Patient::class)->create($patientArray);
        $response=$this->json('POST', '/api/patient', $patientArray);
        
        $response->assertStatus(200);
        $this->assertArrayHasKey("birth_date",$response->original);
        $this->assertDatabaseHas('patients',$patientArray);
    }

    public function testDeletePatient()
    {
        $userTypeId  = factory(UserType::class)->create(['name'=>'patient'])->id;
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;
        $practitioner_id  = factory(Practitioner::class)->create()->id;
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
            'practitioner_id' => $practitioner_id,
            'organization_id' => factory(Organization::class)->create()->id
        ];
        
        factory(\App\Models\Patient::class)->create($patientArray);
		$response=$this->delete('api/patient/1');
		$response->assertStatus(200);
    }

    public  function testUpdate()
   {
        $userTypeId  = factory(UserType::class)->create(['name'=>'patient'])->id;
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;
        $practitioner_id  = factory(Practitioner::class)->create()->id;
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
            'practitioner_id' => $practitioner_id,
            'organization_id' => factory(Organization::class)->create()->id
        ];
        factory(\App\Models\Patient::class)->create($patientArray);
        $this->json('POST', '/api/patient', $patientArray);
        $updatePatientArray = [
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'gender' => factory(CodeableConcept::class)->create()->id
        ];

        $response=$this->json('PUT', '/api/patient/1', $updatePatientArray);
        $response->assertStatus(200);
        $this->assertArrayHasKey("photo",$response->original);
        $this->assertDatabaseHas('patients',$updatePatientArray);

   }

   public function testShowPatient()
   {
        $userTypeId  = factory(UserType::class)->create(['name'=>'patient'])->id;
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;
        $practitioner_id  = factory(Practitioner::class)->create()->id;
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
            'practitioner_id' => $practitioner_id,
            'organization_id' => factory(Organization::class)->create()->id
        ];
        factory(\App\Models\Patient::class)->create($patientArray);
        $response=$this->json('GET', '/api/patient/1', $patientArray);
        $response->assertStatus(200);
        $this->assertArrayHasKey("address",$response->original);
        $this->assertDatabaseHas('patients',$patientArray);
   }

}
