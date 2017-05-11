<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IngredientsTest extends TestCase
{
    public function testStoreIngredient(){

    	$ingredient=array(
    		'quantity'=>10,
    		'substance'=>1
    		);
    	$response=$this->post('/api/ingredient',$ingredient);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListIngredients(){

    	$response=$this->get('/api/ingredient');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('substance', $data);
    }

    public function testListIngredient(){

    	$response=$this->get('/api/ingredient/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('substance', $data);
    }

    public function testUpdateIngredient(){

    	$ingredient=array(
    		'quantity'=>10,
    		'substance'=>12
    		);
    	$response=$this->put('/api/ingredient/1',$ingredient);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('id', $data);
    }

    public function testDeleteIngredient(){
    	
    	$response=$this->delete('/api/ingredient/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
}
