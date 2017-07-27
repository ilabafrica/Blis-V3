<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QuantityTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->quantityData=array(
        
			"value"=>'Sample String',
			"comparator"=>'Sample String',
			"unit"=>'Sample String',
			"system"=>'Sample String',
			"code"=>'Sample String',

        );
    	$this->updatedquantityData=array(
        
			"value"=>'Sample updated String',
			"comparator"=>'Sample updated String',
			"unit"=>'Sample updated String',
			"system"=>'Sample updated String',
			"code"=>'Sample updated String',

        );
	}

	public function testStoreQuantity()
	{
		$response=$this->json('POST', '/api/quantity',$this->quantityData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("system",$response->original);
	}

	public function testListQuantity()
	{
		$response=$this->json('GET', '/api/quantity');
		$response->assertStatus(200);
		
	}

	public function testShowQuantity()
	{
		$this->json('POST', '/api/quantity',$this->quantityData);
		$response=$this->json('GET', '/api/quantity/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("system",$response->original);
	}

	public function testUpdateQuantity()
	{
		$this->json('POST', '/api/quantity',$this->quantityData);
		$response=$this->json('PUT', '/api/quantity/1',$this->updatedquantityData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("system",$response->original);
	}

	public function testDeleteQuantity()
	{
		$this->json('POST', '/api/quantity',$this->quantityData);
		$response=$this->delete('/api/quantity/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/quantity/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeleteQuantityFail()
	{
		$response=$this->delete('/api/quantity/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}