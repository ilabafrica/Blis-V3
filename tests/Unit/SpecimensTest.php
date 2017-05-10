<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpecimensTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Test Create Specimen
     */
    public function testStoreSpecimen(){

    	$specimen=array(
    		'accessionIdentifier'=>"BG1212",
    		'status'=>"1", //Codeable Concept Code e.g unsatisfactory
    		'type'=>"112", //Codeable Concept Code e.g Serum
    		'subject'=>"1", //patient ID
    		'received_time'=>"2017:12:12 15:30:00",
    		'parent'=>"1", //Specimen id from which the specimen originated
    		'note'=>"It is satisfactory" //comment
    		);
    	$response=$this->post('/api/specimen/',$specimen);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListSpecimen(){
    	\Log::info("List Specimen");
    	$response=$this->get('specimen');

    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('accessionIdentifier', $data);
    }

    public function testUpdateSpecimen(){
    	$specimen=array(
    		'accessionIdentifier'=>"BG1212",
    		'status'=>"1", //Codeable Concept Code e.g unsatisfactory
    		'type'=>"12" //Codeable Concept Code e.g Serum
    		);
    	$response=$this->put('/api/specimen/1',$specimen);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testDeleteSpecimen(){
    	
    	$response=$this->delete('/api/specimen/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
