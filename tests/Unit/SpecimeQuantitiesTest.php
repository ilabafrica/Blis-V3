<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpecimeQuantitiesTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::SetUp();
        $this->setVariables();
    }


    public function setVariables()
    {
        $this->specimenquantityData=array(
            "value"=>'sample x',
            "comparator"=>'sample y',
            "unit"=>'ml',
            "system"=>'',
            "code"=>'1',
            );
        $this->updatedspecimenquantityData=array(
            "value"=>'200mg',
            "comparator"=>'sample y updated',
            "unit"=>'ml',
            "system"=>'',
            "code"=>1,
            );
    }

    public function testStoreSpecimenQuantity(){

       	$response=$this->json('POST','/api/quantity',$this->specimenquantityData);
    	$response->assertStatus(200);
        $this->assertArrayHasKey("code", $response->original);
    }

    public function testListSpecimenQuantity(){

    	$response=$this->json('GET', '/api/quantity');
        $response->assertStatus(200);
    }
    public function testShowSpecimenQuantity()
    {
        $this->json('POST', '/api/quantity',$this->specimenquantityData);
        $response=$this->json('GET', '/api/quantity/1');
        $response->assertStatus(200);
        $this->assertArrayHasKey("code",$response->original);
        
    }
    
    public function testUpdateSpecimenQuantity(){

    	$this->json('POST', '/api/quantity',$this->specimenquantityData);
        $response = $this->json('PUT', '/api/quantity/1', $this->updatedspecimenquantityData);
        $response->assertStatus(200);
        $this->assertArrayHasKey("code",$response->original);
    }

    public function testDeleteSpecimenQuantity(){
    	
    	$this->json('POST', '/api/quantity',$this->specimenquantityData);
        $response=$this->delete('/api/quantity/1');
        $this->assertEquals(200, $response->getStatusCode());
        $response=$this->json('GET', '/api/quantity/1');
        $this->assertEquals(404, $response->getStatusCode());
    }
    public function testDeleteSpecimenQuantityFail()
    {
        $response=$this->delete('/api/quantity/9999999999');
        $this->assertEquals(404, $response->getStatusCode());
    }

}
