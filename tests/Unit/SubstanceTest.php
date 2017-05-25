<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubstanceTest extends TestCase
{
     public function testStoreSubstance(){

    	$substance=array(
    		'status'=>10,
    		'category'=>1,
    		'code'=>1,
    		'description'=>"la la land"
    		);
    	$response=$this->post('/api/substance',$substance);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListSubstance(){

    	$response=$this->get('/api/substance');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('code', $data);
    }

    public function testListSubstances(){

    	$response=$this->get('/api/substance/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('code', $data);
    }

    public function testUpdateSubstance(){

    	$substance=array(
    		'status'=>10,
    		'category'=>1,
    		'code'=>1,
    		'description'=>"la la landy"
    		);
    	$response=$this->put('/api/substance/1',$substance);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('id', $data);
    }

    public function testDeleteSubstance(){
    	
    	$response=$this->delete('/api/substance/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
