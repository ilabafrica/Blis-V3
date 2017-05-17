<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatusTest extends TestCase
{
  public function testStoreStatus(){

    	$status=array(
    		'name'=>"Discharged"
    		);
    	$response=$this->post('/api/status',$status);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListStatuses(){

    	$response=$this->get('/api/status');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('name', $data);
    }

    public function testListStatus(){

    	$response=$this->get('/api/status/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('name', $data);
    }

    public function testUpdateStatus(){

    	$status=array(
    		'name'=>"Discharged"
    		);
    	$response=$this->put('/api/status/1',$status);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('id', $data);
    }

    public function testDeleteStatus(){
    	
    	$response=$this->delete('/api/status/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
