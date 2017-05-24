<?php

namespace Tests\Unit;

use App\User;
use App\Models\HumanName;
use App\Models\Patient;
use App\Models\CodeableConcept;
use App\Models\Address;
use App\Models\ContactPoint;
use App\Models\Organization;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//	A contact party (e.g. guardian, partner, friend) for the patient.

class PatientContactTest extends TestCase
{
    public function setup(){
        parent::setup();
        $this->setVariables();
    }

    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function setVariables()
    {
    	$userId  = factory(User::class)->create()->id;
        $patientId  = factory(Patient::class)->create(['user_id'=>$userId])->id;
        $this->patientcontactdata = array(
 			'patient_id' => $patientId,
            'relationship' =>  factory(CodeableConcept::class)->create()->id,
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create()->id,
            'gender' =>  \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
            'organization_id' => factory(Organization::class)->create(['user_id'=>$userId])->id,
            'period' => \Faker\Factory::create()->date()
    		);
        $this->PatientContactUpdate = array (
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create()->id,
            'gender' =>  \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
            'organization_id' => factory(Organization::class)->create(['user_id'=>$userId])->id,
            'period' => \Faker\Factory::create()->date()
        	);
    }
    public function testStorePatientContact()
    {
        $this->post('/api/patientcontact', $this->patientcontactdata);

        $this->assertDatabaseHas('patient_contacts', $this->patientcontactdata);
    }
    public function testDeletePatientContact()
    {
        $patientcontacts = factory(Patient::class,3)->make();

        $patientcontact = Patient::orderBy('id','dec')->take(1)->get()->toArray();

        $PatientContactDeleted = $patient->delete('api/patient_contacts',$patientcontact[0]['id']);
        
        $this->assertEquals(200, $PatientContactDeleted->getStatusCode());

        
    }

    public  function testUpdatePatientContact()
   {
    $PatientContact = factory(Patient::class,3)->make();

      $patientcontactSaved = Patient::orderBy('id','dec')->take(1)->get()->toArray();

     $updatePatientContact =  $this->update($this->PatientContactUpdate ,$patientcontactSaved[0]['id']);

    $this->put('api/patient_contacts',$updatePatientContact);
   }

   public function testShowPatientPatientContact()
   {

    $PatientContacts = factory(Patient::class,3)->create();

    $patientcontacts =  $this->json('GET','api/patient_contacts',$PatientContacts)
                    ->seejson([
                        'created'=> true,
                        ]);
    
    $array = json_decode($patientcontacts);
   
     $result = false;

     if ($array[0]->id==1)
     {
        $result = true;
     }
     $this->assertEquals(true, $result);   
   }

}
