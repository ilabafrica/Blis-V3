<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatusHistoryTest extends TestCase
{
    public function testStoreStatusHistory(){

    	$history=array(
    		'code'=>10,
    		'episode_of_care_id'=>1
    		);
    	$response=$this->post('/api/status_history',$history);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListStatusHistories(){

    	$response=$this->get('/api/status_history');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('episode_of_care_id', $data);
    }

    public function testListStatusHistory(){

    	$response=$this->get('/api/status_history/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('episode_of_care_id', $data);
    }

    public function testUpdateStatusHistory(){

    	$history=array(
    		'code'=>100,
    		'episode_of_care_id'=>1
    		);
    	$response=$this->put('/api/status_history/1',$history);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('id', $data);
    }

    public function testDeleteStatusHistory(){
    	
    	$response=$this->delete('/api/status_history/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
