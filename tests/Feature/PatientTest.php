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
    public function testaddNewPatient()
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

        $this->post('/api/patient/add', $patientArray);

        $this->assertDatabaseHas('patients',$patientArray);
    }

    function testDeletePatient()
    {
        $user = User::find(1);

        $user->delete();

    }





}
