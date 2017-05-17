<?php

namespace Tests\Feature;

use App\User;
use App\DB\ContactPoint;
use Faker\Generator as Facker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactPointTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function setVariables()

    {
    	$this->ContactPointData = array(

    		 'user_id' => factory(User::class)->create()->id,
            'system' =>  \Faker\Factory::create()->randomElement(['phone', 'fax', 'email', 'pager', 'url', 'sms', 'other']),
            'value' => \Faker\Factory::create()->word,
            'use' =>  \Faker\Factory::create()->randomElement(['home', 'work', 'temp', 'old', 'mobile']),
            'rank' => \Faker\Factory::create()->number,
            'period' => \Faker\Factory::create()->date()
            );
    	$this->ContactPointDataUpdate = array(

    		);
    }
     public function testStoreContactPoint()
    {

        $ContactPoint = $this->ContactPointData;

        $this->post('/api/contactpoint', $ContactPoint);

        $this->assertDatabaseHas('contact_points',$ContactPointData);
    }

    public function testUpdateContactPoint()
    {
    	$contactpoint = factory(ContactPoint::class,3)->make();
    	$this->post('api/contactpoint',$contactpoint);
    	$contactpointSaved = ContactPoint::orderBy('id','desc')->take(1)->get()->toArray();

    	$contactpointupdated = $this->update(
    		$this->ContactPointDataUpdate,$contactpointSaved[0]['id']);
    	$this->put('api/contactpoint',$contactpointupdated);
    	$this->assertEquals(200, $contactpointupdated->getStatusCode());

    }

     public function testContactPointDeleted()
     {
     	factory(ContactPoint::class,3)->make();
     	$contactpoint = ContactPoint::orderBy('id','desc')->take(1)->get()->toArray();
     	$contactpointdeleted = $contactpoint->delete('api/contactpoint',$contactpoint[0]['id']);

     	$this->assertEquals(200, $contactpointdeleted->getStatusCode());
     }
    public function testShowContactPoint()
    {
        $contactpoints =  factory(ContactPoint::class,3)->create();
        $contactpoint = $this->json('GET','api/contactpoint',$contactpoints)
        				->seeJson([
        					'result'=>true]);

        $array = json_decode($contactpoint);
        $result = false;

        if($array[0]->id==1)
        {
        	$result = true;
        }	
        $this->assertEquals(true, $result);
    }
}
