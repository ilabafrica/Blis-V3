<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpecimenContainerTest extends TestCase
{
    use DatabaseMigrations;


    public function setup()
    {
        parent::Setup();
        $this->setVariables();
    }

    public function setVariables()
    {
        $this->specimencontainerData=array(
            "description"=>'Sample String',
            "type"=>1,
            "capacity"=>20,
            "quantity_id"=>1,
            "additive"=>1,
            );
        $this->updatedspecimencontainerData=array(
            "description"=>'Sample updated String',
            "type"=>1,
            "capacity"=>200,
            "quantity_id"=>1,
            "additive"=>1,
            
            );
    }
    public function testStoreSpecimenContainer(){

    	
    	$response=$this->json('POST','/api/container',$this->specimencontainerData);
    	$response->assertStatus(200);
        $this->assertArrayHasKey("capacity", $response->original);
    }

    public function testListSpecimenContainer(){

    	$response=$this->json('GET','/api/container');
    	$response->assertStatus(200);
    	
    }

    public function testShowSpecimenContainer(){
        $this->json('POST','/api/container',$this->specimencontainerData);
    	$response=$this->json('GET','/api/container/1');
    	$response->assertStatus(200);
    	$this->assertArrayHasKey("description", $response->original);
    }

    public function testUpdateSpecimenContainer(){

    	$this->json('POST','/api/container',$this->specimencontainerData);
    	$response=$this->json('PUT','/api/container/1',$this->updatedspecimencontainerData);
    	$response->assertStatus(200);
      	$this->assertArrayHasKey('description', $response->original);
    }

    public function testDeleteSpecimenContainer(){
    	$this->json('POST','/api/container',$this->specimencontainerData);
    	$response=$this->delete('/api/container/1');
    	$this->assertEquals(200,$response->getStatusCode());

        $response=$this->json('GET','/api/container/1');
        $this->assertEquals(404, $response->getStatusCode());
    }
    public function testDeleteSpecimenContainerFail()
    {
        $response=$this->delete('/api/container/9999999999');
        $this->assertEquals(404, $response->getStatusCode());
    }
}
