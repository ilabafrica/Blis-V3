<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;



class CodeableConceptTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testcreateCodeableConcept()
    {
    	$codeable_concept = array(
    		'code' =>"status_suspended" , 
    		'description' =>'Suspended'
    		);

    	$response=$this->post('/api/codeable_concept', $codeable_concept);

        $this->assertEquals(200,$response->getStatusCode());
        $data = json_decode($response->getBody(true), true);
    	$this->assertArrayHasKey('code', $data);
    }
    /**
     * [testupdateCodeableConcept description]
     * @return [type] [description]
     */
    public function testupdateCodeableConcept()
    {
    	$codeable_concept = array(
    		'code' =>"status_active" , 
    		'description' =>'Active'
    		);

    	$response=$this->put('/api/codeable_concept/1', $codeable_concept);

        $this->assertTrue(true);

        $this->assertEquals(200,$response->getStatusCode());
    }

    /**
     * [testlistCodeableConcept description]
     * @return [type] [description]
     */
    public function testlistCodeableConcept()
    {
    	
    	$response=$this->call('GET','/api/codeable_concept');



    	$this->assertEquals(200,$response->getStatusCode());

 		
        
    }

    public function testlistCodeableConcepts()
    {
    	$response=$this->get('/api/codeable_concept/1');

        $this->assertTrue(true);
        $this->assertEquals(200,$response->getStatusCode());
    }

    public function testdeleteCodeableConcept()
    {
    	$response=$this->delete('/api/codeable_concept/1');
		$this->assertEquals(200,$response->getStatusCode());
        $this->assertTrue(true);
    }
}
