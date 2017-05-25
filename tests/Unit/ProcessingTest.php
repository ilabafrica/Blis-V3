<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProcessingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
   
    public function testStoreProcess(){

    	$process=array(
    		'description'=>"Exposure to heat",
    		'procedure'=>1,
    		'period'=>"2014-12-12 12:12:00"
    		);
    	$response=$this->post('/api/process',$process);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListProcesses(){

    	$response=$this->get('/api/process');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('procedure', $data);
    }

    public function testListProcess(){

    	$response=$this->get('/api/process/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('procedure', $data);
    }

    public function testUpdateProcess(){

    	$process=array(
    		'description'=>"Bacterial Swaps",
    		'procedure'=>1,
    		'period'=>"2014-12-12 12:12:00"
    		);
    	$response=$this->put('/api/process/1',$process);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('procedure', $data);
    }

    public function testDeleteProcess(){
    	
    	$response=$this->delete('/api/process/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
