<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpecimeQuantitiesTest extends TestCase
{
    public function testStoreSpecimenQuantity(){

    	$specimenquantity=array(
    		'value'=>"sample x",
    		'comparator'=>"sample y",
    		'unit'=>"ml",
    		'system'=>"",
    		'code'=>"1"
    		);
    	$response=$this->post('/api/specimen_quantity',$specimenquantity);

    	$response->assertStatus(200);
    }

    public function testListSpecimenQuantities(){

    	$response=$this->get('/api/specimen_quantity');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('value', $data);
    }

    public function testListSpecimenQuantity(){

    	$response=$this->get('/api/specimen_quantity/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('value', $data);
    }

    public function testUpdateSpecimenQuantity(){

    	$specimenquantity=array(
    		'value'=>"200mg",
    		'comparator'=>"sample y",
    		'unit'=>"ml",
    		'system'=>"",
    		'code'=>"1"
    		);
    	$response=$this->put('/api/specimen_quantity/1',$specimenquantity);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('id', $data);
    }

    public function testDeleteSpecimenQuantity(){
    	
    	$response=$this->delete('/api/specimen_quantity/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
