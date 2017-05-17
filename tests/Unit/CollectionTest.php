<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CollectionTest extends TestCase
{
    
    public function testStoreCollection(){

    	$collection=array(
    		'collector'=>1,
    		'collection_time'=>"2014-12-12 12:12:00",
    		'quantity_id'=>1, //Refer to
    		'method'=>1,
    		'body_site'=>1
    		);
    	$response=$this->post('/api/collection',$collection);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListCollections(){

    	$response=$this->get('/api/collection');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('collector', $data);
    }

    public function testListCollection(){

    	$response=$this->get('/api/collection/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('collector', $data);
    }

    public function testUpdateCollection(){

    	$collection=array(
    		'collector'=>2,
    		'collection_time'=>"2014-12-12 12:12:00"
    		);
    	$response=$this->put('/api/collection/1',$collection);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('collector', $data);
    }

    public function testDeleteCollection(){
    	
    	$response=$this->delete('/api/collection/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
