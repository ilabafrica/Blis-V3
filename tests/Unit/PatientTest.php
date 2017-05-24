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
    /**
     * A basic test example.
     *
     * @return void
     */

    use DatabaseMigrations;

    /*@Test*/

    /**
     *
     */
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
        $patient = factory(Patient::class,3)->make();

        $patient = Patient::orderBy('id','dec')->take(1)->get()->toArray();

        $PatientDeleted = $patient->delete('api/patient',$patient[0]['id']);
        
        $this->assertEquals(200, $PatientDeleted->getStatusCode());

        
    }

    public  function testUpdate()
   {
    //$patient = factory(Patient::class,3)->make();

      $patientSaved = Patient::orderBy('id','dec')->take(1)->get()->toArray();

     $updatePatient =  $this->update($this->PatientUpdate,$patientSaved[0]['id']);

    $this->put('api/patient',$updatePatient);
   }

   public function testShowPatient()
   {

    $patient = factory(Patient::class,3)->create();

    $patients =  $this->json('GET','api/patient',$patient)
                    ->seejson([
                        'created'=> true,
                        ]);
    
    $array = json_decode($patients);
   
     $result = false;

     if ($array[0]->id==1)
     {
        $result = true;
     }
     $this->assertEquals(true, $result);   
   }

}
