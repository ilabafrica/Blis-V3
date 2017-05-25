<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpecimenContainerTest extends TestCase
{
    public function testStoreSpecimenContainer(){

    	$specimencontainer=array(
    		'description'=>"sample x",
    		'type'=>1,
    		'capacity'=>"20",
    		'quantity_id'=>1,
    		'additive'=>1
    		);
    	$response=$this->post('/api/specimencontainer',$specimencontainer);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListSpecimenContainers(){

    	$response=$this->get('/api/specimencontainer');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('description', $data);
    }

    public function testListSpecimenContainer(){

    	$response=$this->get('/api/specimencontainer/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('description', $data);
    }

    public function testUpdateSpecimenContainer(){

    	$specimencontainer=array(
    		'description'=>"Sample y",
    		'type'=>1,
    		'capacity'=>"200"
    		
    		);
    	$response=$this->put('/api/specimencontainer/1',$specimencontainer);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('description', $data);
    }

    public function testDeleteSpecimenContainer(){
    	
    	$response=$this->delete('/api/specimencontainer/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
