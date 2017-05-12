<?php

namespace Tests\Feature;

use App\DB\Practitioner;
use Faker\Generator as Facker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PractitionerCommunicationTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testaddNewPractitionerCommunication()
    {
        $practitionerId  = factory(Practitioner::class)->create()->id;
        $patientId  = factory(Patient::class)->create()->id;
        $PractitionerCommunicationArray = [
            'practitioner_id' => $practitionerId,
            'patient_id' => $patientId,
            'language' =>  \Faker\Factory::create()->randomElement([
                'sw',
                'en',
                'fr',
                'es',
                'de',
                'ar',
                'zh'
            ]),

        ];

        $this->post('/api/practitionercommunication/', $PractitionerCommunicationArray);

        $this->assertDatabaseHas('practitioner_communication',$PractitionerCommunicationArray);
    }
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
