<?php

namespace Tests\Feature;

use App\DB\HumanName;
use App\User;
use App\UserType;
use App\DB\Patient;
use Faker\Generator as Facker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
            'gender' => \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
            'birth_date' => \Faker\Factory::create()->date(),
            'deceased' => \Faker\Factory::create()->boolean(),
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
            'marital_status' => \Faker\Factory::create()->randomElement([
                'annulled',
                'divorced',
                'interlocutory',
                'legally_separated',
                'married',
                'polygamous',
                'never_married',
                'domestic_partner',
                'unmarried',
                'widowed',
                'unknown'
            ]),
            'multiple_birth' => 1,
            'photo' => 'path/to/photo/here',
            'general_practitioner_type' => \Faker\Factory::create()->randomElement(['organization', 'practitioner']),
            'general_practitioner_id' => 1,
            'managing_organization' => factory(Organization::class)->create()->id
        );

      $this->inputUpdate = array(
             'gender' => \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
            'birth_date' => \Faker\Factory::create()->date(),
            'deceased' => \Faker\Factory::create()->boolean(),
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
            'marital_status' => \Faker\Factory::create()->randomElement([
                'annulled',
                'divorced',
                'interlocutory',
                'legally_separated',
                'married',
                'polygamous',
                'never_married',
                'domestic_partner',
                'unmarried',
                'widowed',
                'unknown'
            ]),
            'multiple_birth' => 1,
            'general_practitioner_type' => \Faker\Factory::create()->randomElement(['organization', 'practitioner']),
            'general_practitioner_id' => 1,
            'managing_organization' => factory(Organization::class)->create()->id);
    }
    public function testStore()
    {
        $userTypeId  = factory(UserType::class)->create(['name'=>'patient'])->id;
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;
        $patientArray = [
            'user_id' => $userId,
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'gender' => \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
            'birth_date' => \Faker\Factory::create()->date(),
            'deceased' => \Faker\Factory::create()->boolean(),
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
            'marital_status' => \Faker\Factory::create()->randomElement([
                'annulled',
                'divorced',
                'interlocutory',
                'legally_separated',
                'married',
                'polygamous',
                'never_married',
                'domestic_partner',
                'unmarried',
                'widowed',
                'unknown'
            ]),
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
        //$patient = factory(App\patient::class,3)->make();

        $patient = Patient::orderBy('id','dec')->take(1)->get()->toArray();

        $PatientDelet = $patient->delete('api/patient',$patient[0]['id']);
        
        $patientDeleted = Patient::withTrashed()
                        ->find($PatientDelet);

        
    }

    public  function testUpdate()
   {
    //$patient = factory(Patient::class,3)->make();

      $patientSaved = Patient::orderBy('id','dec')->take(1)->get()->toArray();

     $updatePatient =  $this->update($this->inputUpdate,$patientSaved[0]['id']);

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
